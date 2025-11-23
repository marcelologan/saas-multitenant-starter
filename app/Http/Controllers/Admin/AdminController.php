<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function settings(Request $request)
    {
        $tenantId = $request->user()->tenant_id;

        // Carregar usuários
        $users = User::byTenant($tenantId)
            ->with(['userRoles.role'])
            ->orderBy('name')
            ->get();

        // Carregar roles
        $roles = Role::byTenant($tenantId)
            ->with(['rolePermissions.permission', 'users'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Carregar permissões agrupadas
        $permissions = Permission::byTenant($tenantId)
            ->active()
            ->orderBy('group')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->groupBy('group');

        return view('admin.settings', compact('users', 'roles', 'permissions'));
    }
}
