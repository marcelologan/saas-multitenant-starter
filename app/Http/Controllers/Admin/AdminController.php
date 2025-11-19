<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Painel de configurações administrativas
     */
    public function settings(Request $request)
    {
        $users = User::where('tenant_id', $request->user()->tenant_id)
                    ->with('tenant')
                    ->orderBy('created_at', 'desc')
                    ->get();

        // Roles hardcoded por enquanto
        $roles = collect([
            (object)['slug' => 'admin-empresa', 'name' => 'Admin Empresa'],
            (object)['slug' => 'gerente', 'name' => 'Gerente'],
            (object)['slug' => 'funcionario', 'name' => 'Funcionário'],
            (object)['slug' => 'cliente', 'name' => 'Cliente'],
        ]);

        return view('admin.settings', compact('users', 'roles'));
    }
}