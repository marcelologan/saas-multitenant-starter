<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Tenant;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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

        // Criar permissions para cada tenant existente
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            foreach ($permissions as $permissionData) {
                Permission::create(array_merge($permissionData, [
                    'tenant_id' => $tenant->id,
                ]));
            }
        }

        // Criar permissions globais (sem tenant) se necessário
        foreach ($permissions as $permissionData) {
            Permission::create(array_merge($permissionData, [
                'tenant_id' => null, // Permissions globais
            ]));
        }
    }
}