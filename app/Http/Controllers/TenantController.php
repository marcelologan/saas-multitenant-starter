<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class TenantController extends Controller
{
    /**
     * Atualizar dados da empresa (apenas admin)
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Verificar se é admin
        if (!$user->isAdmin()) {
            abort(403, 'Apenas administradores podem alterar dados da empresa.');
        }

        $tenant = $user->tenant;

        // Regras base de validação
        $rules = [
            'trade_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'complement' => ['nullable', 'string', 'max:255'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'size:2'],
        ];

        // Admin pode alterar status
        if ($user->isAdmin()) {
            $rules['status'] = ['required', Rule::in(['active', 'inactive'])];
        }

        $validated = $request->validate($rules);

        // Se não for admin, manter status atual
        if (!$user->isAdmin()) {
            $validated['status'] = $tenant->status;
        }

        $tenant->update($validated);

        return Redirect::route('profile.edit')->with('success', 'Dados da empresa atualizados com sucesso!');
    }
}
