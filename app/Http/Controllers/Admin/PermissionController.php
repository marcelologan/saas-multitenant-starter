<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * Store a newly created permission
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9._-]+$/'],
            'description' => ['nullable', 'string', 'max:500'],
            'group' => ['required', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        try {
            // Verificar se o slug já existe para este tenant
            $existingPermission = Permission::where('tenant_id', $request->user()->tenant_id)
                ->where('slug', $validated['slug'])
                ->first();

            if ($existingPermission) {
                return redirect()->route('admin.settings', ['tab' => 'permissions'])
                    ->with('error', 'Já existe uma permissão com este slug.');
            }

            // ✅ EXTRAIR MODULE E ACTION DO SLUG
            $slugParts = explode('.', $validated['slug']);
            $module = $slugParts[0] ?? $validated['group']; // Usar primeira parte do slug ou group como fallback
            $action = $slugParts[1] ?? 'manage'; // Usar segunda parte ou 'manage' como fallback

            Permission::create([
                'tenant_id' => $request->user()->tenant_id,
                'module' => $module, // ✅ ADICIONAR ESTE CAMPO
                'action' => $action, // ✅ ADICIONAR ESTE CAMPO
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'],
                'group' => $validated['group'],
                'sort_order' => $validated['sort_order'] ?? 0,
                'is_active' => $validated['is_active'] ?? true,
                'is_system' => false,
            ]);

            return redirect()->route('admin.settings', ['tab' => 'permissions'])
                ->with('success', 'Permissão criada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings', ['tab' => 'permissions'])
                ->with('error', 'Erro ao criar permissão: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified permission
     */
    public function update(Request $request, Permission $permission)
    {
        // Verificar se a permissão pertence ao tenant
        if ($permission->tenant_id !== $request->user()->tenant_id) {
            abort(403, 'Acesso negado.');
        }

        // Não permitir edição de permissões do sistema
        if ($permission->is_system) {
            return redirect()->route('admin.settings', ['tab' => 'permissions'])
                ->with('error', 'Não é possível editar permissões do sistema.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9._-]+$/'],
            'description' => ['nullable', 'string', 'max:500'],
            'group' => ['required', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        try {
            // Verificar se o slug já existe para este tenant (exceto a própria permissão)
            $existingPermission = Permission::where('tenant_id', $request->user()->tenant_id)
                ->where('slug', $validated['slug'])
                ->where('id', '!=', $permission->id)
                ->first();

            if ($existingPermission) {
                return redirect()->route('admin.settings', ['tab' => 'permissions'])
                    ->with('error', 'Já existe uma permissão com este slug.');
            }

            // ✅ EXTRAIR MODULE E ACTION DO SLUG
            $slugParts = explode('.', $validated['slug']);
            $module = $slugParts[0] ?? $validated['group'];
            $action = $slugParts[1] ?? 'manage';

            $permission->update([
                'module' => $module, // ✅ ADICIONAR ESTE CAMPO
                'action' => $action, // ✅ ADICIONAR ESTE CAMPO
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'],
                'group' => $validated['group'],
                'sort_order' => $validated['sort_order'] ?? $permission->sort_order,
                'is_active' => $validated['is_active'] ?? $permission->is_active,
            ]);

            return redirect()->route('admin.settings', ['tab' => 'permissions'])
                ->with('success', 'Permissão atualizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings', ['tab' => 'permissions'])
                ->with('error', 'Erro ao atualizar permissão: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified permission
     */
    public function destroy(Request $request, Permission $permission)
    {
        // Verificar se a permissão pertence ao tenant
        if ($permission->tenant_id !== $request->user()->tenant_id) {
            abort(403, 'Acesso negado.');
        }

        // Não permitir exclusão de permissões do sistema
        if ($permission->is_system) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Não é possível excluir permissões do sistema.'
                ], 422);
            }

            return redirect()->route('admin.settings', ['tab' => 'permissions'])
                ->with('error', 'Não é possível excluir permissões do sistema.');
        }

        try {
            DB::beginTransaction();

            // Remover todas as associações com roles
            $permission->rolePermissions()->delete();

            // Remover a permissão
            $permission->delete();

            DB::commit();

            // ✅ RETORNAR JSON PARA REQUISIÇÕES AJAX
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permissão excluída com sucesso!'
                ]);
            }

            return redirect()->route('admin.settings', ['tab' => 'permissions'])
                ->with('success', 'Permissão excluída com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            // ✅ RETORNAR JSON PARA REQUISIÇÕES AJAX
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao excluir permissão: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.settings', ['tab' => 'permissions'])
                ->with('error', 'Erro ao excluir permissão: ' . $e->getMessage());
        }
    }
}
