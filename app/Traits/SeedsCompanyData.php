<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;

trait SeedsCompanyData
{
    /**
     * Criar roles padrão para o tenant
     */
    protected function seedRoles(string $tenantId): void
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
            Role::create(array_merge($roleData, [
                'tenant_id' => $tenantId,
            ]));
        }
    }

    /**
     * Criar permissões padrão para o tenant
     */
    protected function seedPermissions(string $tenantId): void
    {
        $permissions = [
            // Dashboard
            [
                'module' => 'dashboard',
                'action' => 'view',
                'name' => 'Ver Dashboard',
                'slug' => 'dashboard.view',
                'description' => 'Visualizar painel principal',
                'is_system' => true,
                'is_active' => true,
                'group' => 'Dashboard',
                'sort_order' => 1,
            ],

            // Produtos
            [
                'module' => 'products',
                'action' => 'view',
                'name' => 'Ver Produtos',
                'slug' => 'products.view',
                'description' => 'Visualizar lista de produtos',
                'is_system' => false,
                'is_active' => true,
                'group' => 'Produtos',
                'sort_order' => 10,
            ],
            [
                'module' => 'products',
                'action' => 'create',
                'name' => 'Criar Produtos',
                'slug' => 'products.create',
                'description' => 'Criar novos produtos',
                'is_system' => false,
                'is_active' => true,
                'group' => 'Produtos',
                'sort_order' => 11,
            ],
            [
                'module' => 'products',
                'action' => 'edit',
                'name' => 'Editar Produtos',
                'slug' => 'products.edit',
                'description' => 'Editar produtos existentes',
                'is_system' => false,
                'is_active' => true,
                'group' => 'Produtos',
                'sort_order' => 12,
            ],
            [
                'module' => 'products',
                'action' => 'delete',
                'name' => 'Excluir Produtos',
                'slug' => 'products.delete',
                'description' => 'Excluir produtos',
                'is_system' => false,
                'is_active' => true,
                'group' => 'Produtos',
                'sort_order' => 13,
            ],

            // Vendas
            [
                'module' => 'sales',
                'action' => 'view',
                'name' => 'Ver Vendas',
                'slug' => 'sales.view',
                'description' => 'Visualizar vendas',
                'is_system' => false,
                'is_active' => true,
                'group' => 'Vendas',
                'sort_order' => 20,
            ],
            [
                'module' => 'sales',
                'action' => 'create',
                'name' => 'Criar Vendas',
                'slug' => 'sales.create',
                'description' => 'Registrar novas vendas',
                'is_system' => false,
                'is_active' => true,
                'group' => 'Vendas',
                'sort_order' => 21,
            ],

            // Usuários
            [
                'module' => 'users',
                'action' => 'view',
                'name' => 'Ver Usuários',
                'slug' => 'users.view',
                'description' => 'Visualizar usuários',
                'is_system' => true,
                'is_active' => true,
                'group' => 'Usuários',
                'sort_order' => 30,
            ],
            [
                'module' => 'users',
                'action' => 'create',
                'name' => 'Criar Usuários',
                'slug' => 'users.create',
                'description' => 'Criar novos usuários',
                'is_system' => true,
                'is_active' => true,
                'group' => 'Usuários',
                'sort_order' => 31,
            ],

            // Relatórios
            [
                'module' => 'reports',
                'action' => 'view',
                'name' => 'Ver Relatórios',
                'slug' => 'reports.view',
                'description' => 'Visualizar relatórios básicos',
                'is_system' => false,
                'is_active' => true,
                'group' => 'Relatórios',
                'sort_order' => 40,
            ],

            // Configurações
            [
                'module' => 'settings',
                'action' => 'manage',
                'name' => 'Gerenciar Configurações',
                'slug' => 'settings.manage',
                'description' => 'Gerenciar configurações do sistema',
                'is_system' => true,
                'is_active' => true,
                'group' => 'Configurações',
                'sort_order' => 50,
            ],
        ];

        foreach ($permissions as $permissionData) {
            Permission::create(array_merge($permissionData, [
                'tenant_id' => $tenantId,
            ]));
        }
    }

    /**
     * Associar permissões às roles
     */
    protected function seedRolePermissions(string $tenantId): void
    {
        // Buscar roles e permissions do tenant
        $adminRole = Role::where('tenant_id', $tenantId)->where('slug', 'admin-empresa')->first();
        $gerenteRole = Role::where('tenant_id', $tenantId)->where('slug', 'gerente')->first();
        $funcionarioRole = Role::where('tenant_id', $tenantId)->where('slug', 'funcionario')->first();
        $clienteRole = Role::where('tenant_id', $tenantId)->where('slug', 'cliente')->first();

        $permissions = Permission::where('tenant_id', $tenantId)->get()->keyBy('slug');

        // ADMIN EMPRESA - Todas as permissões
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

        // GERENTE - Permissões de gestão
        if ($gerenteRole) {
            $gerentePermissions = [
                'dashboard.view',
                'products.view', 'products.create', 'products.edit',
                'sales.view', 'sales.create',
                'reports.view',
                'users.view',
            ];

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

        // FUNCIONÁRIO - Permissões básicas
        if ($funcionarioRole) {
            $funcionarioPermissions = [
                'dashboard.view',
                'products.view',
                'sales.view', 'sales.create',
            ];

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

        // CLIENTE - Acesso limitado
        if ($clienteRole) {
            $clientePermissions = [
                'dashboard.view',
            ];

            foreach ($clientePermissions as $permSlug) {
                if (isset($permissions[$permSlug])) {
                    RolePermission::create([
                        'tenant_id' => $tenantId,
                        'role_id' => $clienteRole->id,
                        'permission_id' => $permissions[$permSlug]->id,
                        'is_granted' => true,
                        'conditions' => json_encode(['limited_access' => true]),
                    ]);
                }
            }
        }
    }

    /**
     * Executar todo o seeding para um novo tenant
     */
    protected function seedCompanyData(string $tenantId): void
    {
        $this->seedRoles($tenantId);
        $this->seedPermissions($tenantId);
        $this->seedRolePermissions($tenantId);
    }
}