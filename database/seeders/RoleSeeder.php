<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Tenant;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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

        // Criar roles para cada tenant existente
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            foreach ($roles as $roleData) {
                Role::create(array_merge($roleData, [
                    'tenant_id' => $tenant->id,
                ]));
            }
        }

        // Criar roles globais (sem tenant) se necessário
        foreach ($roles as $roleData) {
            Role::create(array_merge($roleData, [
                'tenant_id' => null, // Roles globais
            ]));
        }
    }
}