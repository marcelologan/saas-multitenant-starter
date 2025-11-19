<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\Tenant;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            $this->assignPermissionsToRoles($tenant->id);
        }

        // Também para roles globais
        $this->assignPermissionsToRoles(null);
    }

    private function assignPermissionsToRoles($tenantId)
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
}