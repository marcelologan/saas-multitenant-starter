<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validRoles = ['admin-empresa', 'gerente', 'funcionario', 'cliente'];

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', Rule::in($validRoles)],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['tenant_id'] = $request->user()->tenant_id;

        User::create($validated);

        return redirect()->route('admin.settings')
            ->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        if ($user->tenant_id !== $request->user()->tenant_id) {
            abort(403, 'Acesso negado.');
        }

        $validRoles = ['admin-empresa', 'gerente', 'funcionario', 'cliente'];

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 
                       Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', Rule::in($validRoles)],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.settings')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->tenant_id !== $request->user()->tenant_id) {
            abort(403, 'Acesso negado.');
        }

        if ($user->id === $request->user()->id) {
            return redirect()->route('admin.settings')
                ->with('error', 'Você não pode excluir sua própria conta!');
        }

        $user->delete();

        return redirect()->route('admin.settings')
            ->with('success', 'Usuário excluído com sucesso!');
    }
}