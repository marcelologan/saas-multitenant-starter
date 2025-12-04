<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission = 'settings.manage'): Response
    {
        $user = $request->user();

        // Verificar se o usuário está autenticado
        if (!$user) {
            abort(403, 'Acesso negado. Você precisa estar logado.');
        }

        // Verificar se o usuário tem a permissão necessária
        if (!$user->hasPermission($permission)) {
            abort(403, 'Acesso negado. Você não tem permissão para acessar esta área.');
        }

        return $next($request);
    }
}