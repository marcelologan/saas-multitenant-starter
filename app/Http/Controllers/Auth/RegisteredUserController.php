<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Role; // ✅ ADICIONAR
use App\Models\UserRole; // ✅ ADICIONAR
use App\Models\Permission; // ✅ ADICIONAR
use App\Models\RolePermission; // ✅ ADICIONAR
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Buscar planos ativos para exibir na view
        $plans = Plan::active()->orderBy('price')->get();

        return view('auth.register', compact('plans'));
    }

    /**
     * Handle an incoming registration request.
     * 
     * Este método:
     * 1. Cria a empresa (tenant)
     * 2. Cria as roles e permissões padrão para a empresa
     * 3. Cria o usuário administrador da empresa
     * 4. Atribui a role de admin-empresa ao usuário
     * 5. Cria a assinatura do plano
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            // Validação completa dos dados
            $validated = $request->validate([
                // Dados da empresa
                'company_name' => ['required', 'string', 'max:255'],
                'trade_name' => ['nullable', 'string', 'max:255'],
                'cnpj' => ['required', 'string', 'size:18', 'unique:tenants,cnpj'],
                'phone' => ['required', 'string', 'max:20'],
                'address' => ['nullable', 'string', 'max:255'],

                // Dados do administrador
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],

                // Plano selecionado
                'plan_id' => ['required', 'exists:plans,id'],

                // Termos
                'terms' => ['required', 'accepted'],
            ], [
                'company_name.required' => 'A razão social é obrigatória.',
                'cnpj.required' => 'O CNPJ é obrigatório.',
                'cnpj.size' => 'O CNPJ deve ter 18 caracteres (formato: 00.000.000/0000-00).',
                'cnpj.unique' => 'Este CNPJ já está cadastrado em nosso sistema.',
                'phone.required' => 'O telefone é obrigatório.',
                'email.unique' => 'Este email já está cadastrado.',
                'plan_id.required' => 'Selecione um plano.',
                'plan_id.exists' => 'Plano selecionado inválido.',
                'terms.accepted' => 'Você deve aceitar os termos de uso.',
            ]);

            // Usar transação para garantir consistência
            DB::beginTransaction();

            // 1. Criar o Tenant (Empresa)
            $tenant = Tenant::create([
                'company_name' => $validated['company_name'],
                'trade_name' => $validated['trade_name'],
                'cnpj' => $this->cleanCnpj($validated['cnpj']),
                'address' => $validated['address'],
                'status' => 'active',
            ]);

            // 2. Criar roles e permissões para a empresa
            $this->createTenantRoles($tenant->id);
            $this->createTenantPermissions($tenant->id);
            $this->assignPermissionsToRoles($tenant->id);

            // 3. Criar o usuário administrador
            $user = User::create([
                'tenant_id' => $tenant->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'phone' => $this->cleanPhone($validated['phone']),
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            // 4. Atribuir role de admin-empresa ao usuário
            $adminRole = Role::where('tenant_id', $tenant->id)
                ->where('slug', 'admin-empresa')
                ->first();

            if ($adminRole) {
                UserRole::create([
                    'user_id' => $user->id,
                    'tenant_id' => $tenant->id,
                    'role_id' => $adminRole->id,
                    'assigned_at' => now(),
                    'assigned_by' => $user->id,
                    'is_active' => true,
                ]);
            }

            // 5. Buscar o plano selecionado
            $plan = Plan::findOrFail($validated['plan_id']);

            // 6. Criar a assinatura
            $subscription = Subscription::create([
                'tenant_id' => $tenant->id,
                'plan_id' => $plan->id,
                'status' => 'trial',
                'starts_at' => now(),
                'trial_ends_at' => now()->addDays(30),
                'ends_at' => null,
            ]);

            // Confirmar transação
            DB::commit();

            // Disparar evento de registro
            event(new Registered($user));

            // Fazer login automático
            Auth::login($user);

            // Redirecionar para dashboard com mensagem de sucesso
            return redirect()->route('dashboard')->with([
                'success' => 'Conta criada com sucesso! Você tem 30 dias de teste gratuito.',
                'trial_days' => 30,
                'plan_name' => $plan->name,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())
                ->withInput($request->except(['password', 'password_confirmation']))
                ->with('error', 'Verifique os campos obrigatórios.');
        } catch (\Exception $e) {
            // Reverter transação em caso de erro
            DB::rollBack();

            return back()->withInput($request->except(['password', 'password_confirmation']))
                ->with('error', 'Erro ao criar conta. Verifique os dados e tente novamente.');
        }
    }

    /**
     * Criar roles padrão para o tenant
     */
    private function createTenantRoles(string $tenantId): void
    {
        $roles = [
            [
                'name' => 'Admin Empresa',
                'slug' => 'admin-empresa',
                'description' => 'Administrador completo da empresa/tenant',
                'is_system' => true,
                'is_default' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Gerente',
                'slug' => 'gerente',
                'description' => 'Gerenciamento e supervisão do sistema',
                'is_system' => false,
                'is_default' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Funcionário',
                'slug' => 'funcionario',
                'description' => 'Acesso básico ao sistema',
                'is_system' => false,
                'is_default' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Cliente',
                'slug' => 'cliente',
                'description' => 'Acesso limitado para clientes',
                'is_system' => false,
                'is_default' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($roles as $roleData) {
            Role::create(array_merge($roleData, ['tenant_id' => $tenantId]));
        }
    }

    /**
     * Criar permissões padrão para o tenant
     */
    private function createTenantPermissions(string $tenantId): void
    {
        $permissions = [
            // Dashboard
            ['module' => 'dashboard', 'action' => 'view', 'name' => 'Ver Dashboard', 'slug' => 'dashboard.view', 'description' => 'Visualizar painel principal', 'is_system' => true, 'group' => 'Dashboard', 'sort_order' => 1],

            // Produtos
            ['module' => 'products', 'action' => 'view', 'name' => 'Ver Produtos', 'slug' => 'products.view', 'description' => 'Visualizar lista de produtos', 'is_system' => false, 'group' => 'Produtos', 'sort_order' => 10],
            ['module' => 'products', 'action' => 'create', 'name' => 'Criar Produtos', 'slug' => 'products.create', 'description' => 'Criar novos produtos', 'is_system' => false, 'group' => 'Produtos', 'sort_order' => 11],
            ['module' => 'products', 'action' => 'edit', 'name' => 'Editar Produtos', 'slug' => 'products.edit', 'description' => 'Editar produtos existentes', 'is_system' => false, 'group' => 'Produtos', 'sort_order' => 12],
            ['module' => 'products', 'action' => 'delete', 'name' => 'Excluir Produtos', 'slug' => 'products.delete', 'description' => 'Excluir produtos', 'is_system' => false, 'group' => 'Produtos', 'sort_order' => 13],

            // Vendas
            ['module' => 'sales', 'action' => 'view', 'name' => 'Ver Vendas', 'slug' => 'sales.view', 'description' => 'Visualizar vendas', 'is_system' => false, 'group' => 'Vendas', 'sort_order' => 20],
            ['module' => 'sales', 'action' => 'create', 'name' => 'Criar Vendas', 'slug' => 'sales.create', 'description' => 'Registrar novas vendas', 'is_system' => false, 'group' => 'Vendas', 'sort_order' => 21],

            // Usuários
            ['module' => 'users', 'action' => 'view', 'name' => 'Ver Usuários', 'slug' => 'users.view', 'description' => 'Visualizar usuários', 'is_system' => true, 'group' => 'Usuários', 'sort_order' => 30],
            ['module' => 'users', 'action' => 'create', 'name' => 'Criar Usuários', 'slug' => 'users.create', 'description' => 'Criar novos usuários', 'is_system' => true, 'group' => 'Usuários', 'sort_order' => 31],

            // Relatórios
            ['module' => 'reports', 'action' => 'view', 'name' => 'Ver Relatórios', 'slug' => 'reports.view', 'description' => 'Visualizar relatórios básicos', 'is_system' => false, 'group' => 'Relatórios', 'sort_order' => 40],

            // Configurações
            ['module' => 'settings', 'action' => 'manage', 'name' => 'Gerenciar Configurações', 'slug' => 'settings.manage', 'description' => 'Gerenciar configurações do sistema', 'is_system' => true, 'group' => 'Configurações', 'sort_order' => 50],
        ];

        foreach ($permissions as $permissionData) {
            Permission::create(array_merge($permissionData, [
                'tenant_id' => $tenantId,
                'is_active' => true,
            ]));
        }
    }

    /**
     * Associar permissões às roles
     */
    private function assignPermissionsToRoles(string $tenantId): void
    {
        $adminRole = Role::where('tenant_id', $tenantId)->where('slug', 'admin-empresa')->first();
        $gerenteRole = Role::where('tenant_id', $tenantId)->where('slug', 'gerente')->first();
        $funcionarioRole = Role::where('tenant_id', $tenantId)->where('slug', 'funcionario')->first();
        $clienteRole = Role::where('tenant_id', $tenantId)->where('slug', 'cliente')->first();

        $permissions = Permission::where('tenant_id', $tenantId)->get()->keyBy('slug');

        // Admin Empresa - Todas as permissões
        if ($adminRole) {
            foreach ($permissions as $permission) {
                RolePermission::create([
                    'tenant_id' => $tenantId,
                    'role_id' => $adminRole->id,
                    'permission_id' => $permission->id,
                    'is_granted' => true,
                ]);
            }
        }

        // Gerente - Permissões de gestão
        if ($gerenteRole) {
            $gerentePermissions = ['dashboard.view', 'products.view', 'products.create', 'products.edit', 'sales.view', 'sales.create', 'reports.view', 'users.view'];
            foreach ($gerentePermissions as $permSlug) {
                if (isset($permissions[$permSlug])) {
                    RolePermission::create([
                        'tenant_id' => $tenantId,
                        'role_id' => $gerenteRole->id,
                        'permission_id' => $permissions[$permSlug]->id,
                        'is_granted' => true,
                    ]);
                }
            }
        }

        // Funcionário - Permissões básicas
        if ($funcionarioRole) {
            $funcionarioPermissions = ['dashboard.view', 'products.view', 'sales.view', 'sales.create'];
            foreach ($funcionarioPermissions as $permSlug) {
                if (isset($permissions[$permSlug])) {
                    RolePermission::create([
                        'tenant_id' => $tenantId,
                        'role_id' => $funcionarioRole->id,
                        'permission_id' => $permissions[$permSlug]->id,
                        'is_granted' => true,
                    ]);
                }
            }
        }

        // Cliente - Acesso limitado
        if ($clienteRole) {
            $clientePermissions = ['dashboard.view'];
            foreach ($clientePermissions as $permSlug) {
                if (isset($permissions[$permSlug])) {
                    RolePermission::create([
                        'tenant_id' => $tenantId,
                        'role_id' => $clienteRole->id,
                        'permission_id' => $permissions[$permSlug]->id,
                        'is_granted' => true,
                    ]);
                }
            }
        }
    }



    /**
     * Limpar CNPJ (remover pontuação)
     */
    private function cleanCnpj(string $cnpj): string
    {
        return preg_replace('/\D/', '', $cnpj);
    }

    /**
     * Limpar telefone (remover pontuação)
     */
    private function cleanPhone(string $phone): string
    {
        return preg_replace('/\D/', '', $phone);
    }
}
