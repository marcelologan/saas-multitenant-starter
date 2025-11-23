<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Buscar roles válidas para o tenant
        $validRoles = Role::where('tenant_id', $request->user()->tenant_id)
                         ->where('is_active', true)
                         ->pluck('id', 'slug')
                         ->toArray();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_slug' => ['required', Rule::in(array_keys($validRoles))],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        try {
            DB::beginTransaction();

            // Criar o usuário
            $user = User::create([
                'tenant_id' => $request->user()->tenant_id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'status' => $validated['status'],
            ]);

            // Atribuir a role ao usuário
            UserRole::create([
                'tenant_id' => $request->user()->tenant_id,
                'user_id' => $user->id,
                'role_id' => $validRoles[$validated['role_slug']],
                'assigned_at' => now(),
                'assigned_by' => $request->user()->id,
                'is_active' => true,
            ]);

            DB::commit();

            return redirect()->route('admin.settings')
                ->with('success', 'Usuário criado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('admin.settings')
                ->with('error', 'Erro ao criar usuário: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        // Validação: mesmo tenant
        if ($user->tenant_id !== $request->user()->tenant_id) {
            abort(403, 'Acesso negado.');
        }

        // Buscar roles válidas para o tenant
        $validRoles = Role::where('tenant_id', $request->user()->tenant_id)
                         ->where('is_active', true)
                         ->pluck('id', 'slug')
                         ->toArray();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 
                       Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'role_slug' => ['required', Rule::in(array_keys($validRoles))],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        // Validar senha se fornecida
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
        }

        try {
            DB::beginTransaction();

            // Atualizar dados do usuário
            $updateData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'status' => $validated['status'],
            ];

            // Adicionar senha se fornecida
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            // Verificar se a role mudou
            $currentRole = $user->activeRoles()->first();
            $newRoleId = $validRoles[$validated['role_slug']];

            if (!$currentRole || $currentRole->id !== $newRoleId) {
                // Desativar roles atuais
                UserRole::where('user_id', $user->id)
                        ->where('tenant_id', $request->user()->tenant_id)
                        ->update(['is_active' => false]);

                // Criar nova role
                UserRole::create([
                    'tenant_id' => $request->user()->tenant_id,
                    'user_id' => $user->id,
                    'role_id' => $newRoleId,
                    'assigned_at' => now(),
                    'assigned_by' => $request->user()->id,
                    'is_active' => true,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.settings')
                ->with('success', 'Usuário atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('admin.settings')
                ->with('error', 'Erro ao atualizar usuário: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        // Validações
        if ($user->tenant_id !== $request->user()->tenant_id) {
            abort(403, 'Acesso negado.');
        }

        if ($user->id === $request->user()->id) {
            return redirect()->route('admin.settings')
                ->with('error', 'Você não pode excluir sua própria conta!');
        }

        try {
            DB::beginTransaction();

            // Desativar todas as roles do usuário
            UserRole::where('user_id', $user->id)
                    ->where('tenant_id', $request->user()->tenant_id)
                    ->update(['is_active' => false]);

            // Delete do usuário
            $user->delete();

            DB::commit();

            return redirect()->route('admin.settings')
                ->with('success', 'Usuário excluído com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('admin.settings')
                ->with('error', 'Erro ao excluir usuário: ' . $e->getMessage());
        }
    }
}