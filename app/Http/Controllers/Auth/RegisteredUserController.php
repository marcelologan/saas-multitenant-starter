<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr; // ✅ ADICIONAR ESTA LINHA
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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Log dos dados recebidos
        Log::info('=== INÍCIO DO REGISTRO ===');
        Log::info('Dados recebidos:', $request->except(['password', 'password_confirmation']));

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
                // Suas mensagens customizadas...
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

            $validatedForLog = $validated;
            unset($validatedForLog['password']);
            Log::info('Validação passou! Dados validados:', $validatedForLog);
            
            // Usar transação para garantir consistência
            DB::beginTransaction();
            Log::info('Transação iniciada');

            // 1. Criar o Tenant (Empresa)
            $tenant = Tenant::create([
                'company_name' => $validated['company_name'],
                'trade_name' => $validated['trade_name'],
                'cnpj' => $this->cleanCnpj($validated['cnpj']),
                'address' => $validated['address'],
                'status' => 'active',
            ]);
            Log::info('Tenant criado:', ['id' => $tenant->id, 'company_name' => $tenant->company_name]);

            // 2. Criar o usuário administrador
            $user = User::create([
                'tenant_id' => $tenant->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'], // ✅ SEM Hash::make
                'phone' => $this->cleanPhone($validated['phone']),
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
            Log::info('User criado:', ['id' => $user->id, 'email' => $user->email]);

            // 3. Buscar o plano selecionado
            $plan = Plan::findOrFail($validated['plan_id']);
            Log::info('Plano encontrado:', ['id' => $plan->id, 'name' => $plan->name]);

            // 4. Criar a assinatura
            $subscription = Subscription::create([
                'tenant_id' => $tenant->id,
                'plan_id' => $plan->id,
                'status' => 'trial',
                'starts_at' => now(),
                'trial_ends_at' => now()->addDays(30),
                'ends_at' => null,
            ]);
            Log::info('Subscription criada:', ['id' => $subscription->id, 'status' => $subscription->status]);

            // Confirmar transação
            DB::commit();
            Log::info('Transação confirmada');

            // Disparar evento de registro
            event(new Registered($user));
            Log::info('Evento Registered disparado');

            // Fazer login automático
            Auth::login($user);
            Log::info('Login automático realizado');

            Log::info('=== REGISTRO CONCLUÍDO COM SUCESSO ===');

            // Redirecionar para dashboard com mensagem de sucesso
            return redirect()->route('dashboard')->with([
                'success' => 'Conta criada com sucesso! Você tem 30 dias de teste gratuito.',
                'trial_days' => 30,
                'plan_name' => $plan->name,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erro de validação:', $e->errors());

            return back()->withErrors($e->errors())
                ->withInput($request->except(['password', 'password_confirmation']))
                ->with('error', 'Verifique os campos obrigatórios.');
        } catch (\Exception $e) {
            // Reverter transação em caso de erro
            DB::rollBack();

            Log::error('Erro geral no registro:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput($request->except(['password', 'password_confirmation']))
                ->with('error', 'Erro ao criar conta. Verifique os dados e tente novamente.');
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
