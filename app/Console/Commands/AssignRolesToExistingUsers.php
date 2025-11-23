<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;

class AssignRolesToExistingUsers extends Command
{
    protected $signature = 'users:assign-roles';
    protected $description = 'Assign roles to existing users';

    public function handle()
    {
        $users = User::whereDoesntHave('userRoles')->get();

        if ($users->isEmpty()) {
            $this->info('✅ Todos os usuários já têm roles atribuídas.');
            return;
        }

        $this->info("🔄 Encontrados {$users->count()} usuários sem roles.");

        foreach ($users as $user) {
            // Buscar role admin-empresa para o tenant do usuário
            $adminRole = Role::where('tenant_id', $user->tenant_id)
                            ->where('slug', 'admin-empresa')
                            ->first();

            if ($adminRole) {
                UserRole::create([
                    'tenant_id' => $user->tenant_id,
                    'user_id' => $user->id,
                    'role_id' => $adminRole->id,
                    'assigned_at' => now(),
                    'assigned_by' => $user->id,
                    'is_active' => true,
                ]);

                $this->info("✅ Role 'admin-empresa' atribuída para: {$user->name}");
            } else {
                $this->error("❌ Role 'admin-empresa' não encontrada para tenant: {$user->tenant_id}");
            }
        }

        $this->info("🎯 Atribuição de roles concluída!");
    }
}