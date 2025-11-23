<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Store a newly created role
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        try {
            DB::beginTransaction();

            // Gerar slug único
            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;
            $counter = 1;

            while (Role::where('tenant_id', $request->user()->tenant_id)
                ->where('slug', $slug)
                ->exists()
            ) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            // Criar a role
            Role::create([
                'tenant_id' => $request->user()->tenant_id,
                'name' => $validated['name'],
                'slug' => $slug,
                'description' => $validated['description'],
                'sort_order' => $validated['sort_order'] ?? 999,
                'is_active' => true,
                'created_by' => $request->user()->id,
            ]);

            DB::commit();

            return redirect()->route('admin.settings', ['tab' => 'roles'])
                ->with('success', 'Role criada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.settings')
                ->with('error', 'Erro ao criar role: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified role
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        // Verificar se a role pertence ao tenant
        if ($role->tenant_id !== $request->user()->tenant_id) {
            abort(403, 'Acesso negado.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        try {
            $role->update($validated);

            return redirect()->route('admin.settings', ['tab' => 'roles'])
                ->with('success', 'Role atualizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings')
                ->with('error', 'Erro ao atualizar role: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified role
     */
    public function destroy(Request $request, Role $role): RedirectResponse
    {
        // Verificar se a role pertence ao tenant
        if ($role->tenant_id !== $request->user()->tenant_id) {
            abort(403, 'Acesso negado.');
        }

        // Verificar se há usuários com esta role
        $usersCount = $role->users()->count();
        if ($usersCount > 0) {
            return redirect()->route('admin.settings')
                ->with('error', "Não é possível excluir esta role. Há {$usersCount} usuário(s) associado(s).");
        }

        try {
            DB::beginTransaction();

            // Remover permissões da role
            RolePermission::where('role_id', $role->id)->delete();

            // Soft delete da role
            $role->delete();

            DB::commit();

            return redirect()->route('admin.settings', ['tab' => 'roles'])
                ->with('success', 'Role atualizada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.settings')
                ->with('error', 'Erro ao excluir role: ' . $e->getMessage());
        }
    }

    /**
     * Update role permissions
     */
    public function updatePermissions(Request $request, Role $role)
    {
        // Verificar se a role pertence ao tenant
        if ($role->tenant_id !== $request->user()->tenant_id) {
            abort(403, 'Acesso negado.');
        }

        $validated = $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        try {
            DB::beginTransaction();

            // Remover todas as permissões atuais
            RolePermission::where('role_id', $role->id)->delete();

            // Adicionar novas permissões
            if (!empty($validated['permissions'])) {
                foreach ($validated['permissions'] as $permissionId) {
                    RolePermission::create([
                        'tenant_id' => $request->user()->tenant_id,
                        'role_id' => $role->id,
                        'permission_id' => $permissionId,
                        'is_granted' => true,
                    ]);
                }
            }

            DB::commit();

            // Retornar JSON para AJAX
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permissões atualizadas com sucesso!'
                ]);
            }

            return redirect()->route('admin.settings')
                ->with('success', 'Permissões da role atualizadas com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao atualizar permissões: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.settings')
                ->with('error', 'Erro ao atualizar permissões: ' . $e->getMessage());
        }
    }

    /**
     * Get role permissions (for AJAX)
     */
    public function getPermissions(Request $request, Role $role)
    {
        // Verificar se a role pertence ao tenant
        if ($role->tenant_id !== $request->user()->tenant_id) {
            abort(403, 'Acesso negado.');
        }

        $tenantId = $request->user()->tenant_id;

        // Buscar todas as permissões do tenant agrupadas
        $allPermissions = Permission::byTenant($tenantId)
            ->active()
            ->orderBy('group')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->groupBy('group');

        // Buscar permissões já concedidas para esta role
        $rolePermissions = $role->rolePermissions()
            ->where('is_granted', true)
            ->pluck('permission_id')
            ->toArray();

        return response()->json([
            'success' => true,
            'permissions' => $allPermissions,
            'rolePermissions' => $rolePermissions,
            'role' => [
                'id' => $role->id,
                'name' => $role->name
            ]
        ]);
    }
}
