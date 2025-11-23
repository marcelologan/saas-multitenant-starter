<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-flash', function () {
    return redirect('/dashboard')->with('success', 'Teste de flash message funcionando!');
})->middleware('auth');

// Rota para verificar se está logado
Route::get('/verificar-login', function () {
    $isLoggedIn = Auth::check();
    $user = Auth::user();

    return response()->json([
        'logado' => $isLoggedIn,
        'user_id' => $user ? $user->id : null,
        'user_name' => $user ? $user->name : null,
        'user_email' => $user ? $user->email : null,
        'session_id' => session()->getId(),
        'session_data' => session()->all()
    ]);
});

Route::get('/dashboard', function () {
    Log::info('=== ACESSANDO DASHBOARD ===');

    try {
        $user = Auth::user();
        Log::info('User carregado:', ['id' => $user->id, 'name' => $user->name]);

        $tenant = $user->tenant;
        Log::info('Tenant carregado:', ['id' => $tenant->id ?? 'null', 'company_name' => $tenant->company_name ?? 'null']);

        $subscription = $tenant->subscription ?? null;
        Log::info('Subscription carregada:', ['id' => $subscription->id ?? 'null', 'status' => $subscription->status ?? 'null']);

        Log::info('Renderizando view dashboard...');

        return view('dashboard', compact('user', 'tenant', 'subscription'));
    } catch (\Exception $e) {
        Log::error('Erro no dashboard:', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);

        return response()->json(['error' => $e->getMessage()], 500);
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Atualizar dados da empresa
    Route::patch('/tenant', [TenantController::class, 'update'])->name('tenant.update');

    // ✅ ROTAS ADMINISTRATIVAS COM UUID PATTERN
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        // Configurações gerais
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');

        // Gestão de usuários
        Route::resource('users', UserController::class)->except(['index', 'show']);
        Route::get('/users/{user}/data', [UserController::class, 'getUserData'])
            ->name('users.data')
            ->where('user', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

        // Gestão de roles
        Route::resource('roles', RoleController::class)->except(['index', 'show', 'create', 'edit']);
        Route::get('roles/{role}/permissions', [RoleController::class, 'getPermissions'])
            ->name('roles.permissions')
            ->where('role', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
        Route::put('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])
            ->name('roles.permissions.update')
            ->where('role', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

        // ✅ GESTÃO DE PERMISSÕES COM UUID PATTERN
        Route::post('permissions', [PermissionController::class, 'store'])->name('permissions.store');
        Route::put('permissions/{permission}', [PermissionController::class, 'update'])
            ->name('permissions.update')
            ->where('permission', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
        Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])
            ->name('permissions.destroy')
            ->where('permission', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

        // ✅ ADICIONAR UUID PATTERN PARA ROLES E USERS TAMBÉM
        Route::resource('roles', RoleController::class)->except(['index', 'show', 'create', 'edit'])
            ->where(['role' => '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}']);
        Route::resource('users', UserController::class)->except(['index', 'show'])
            ->where(['user' => '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}']);
    });
});

require __DIR__ . '/auth.php';
