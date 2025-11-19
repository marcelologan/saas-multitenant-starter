<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    Log::info('=== TENTATIVA DE LOGIN ===');
    Log::info('Email:', ['email' => $request->email]);

    try {
        // ✅ Verificar se o usuário existe
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if (!$user) {
            Log::error('Usuário não encontrado');
            throw ValidationException::withMessages([
                'email' => 'Credenciais inválidas.',
            ]);
        }
        
        Log::info('Usuário encontrado:', ['id' => $user->id, 'email' => $user->email]);
        
        // ✅ Verificar senha
        if (!Hash::check($request->password, $user->password)) {
            Log::error('Senha incorreta');
            throw ValidationException::withMessages([
                'email' => 'Credenciais inválidas.',
            ]);
        }
        
        Log::info('Senha correta');
        
        // ✅ Fazer login explicitamente
        Auth::login($user, $request->boolean('remember'));
        Log::info('Auth::login() executado');
        
        // ✅ Regenerar sessão
        $request->session()->regenerate();
        Log::info('Sessão regenerada');
        
        // ✅ Verificar se está logado
        $loggedUser = Auth::user();
        Log::info('Verificação após login:', [
            'Auth::check()' => Auth::check(),
            'Auth::id()' => Auth::id(),
            'user_id' => $loggedUser ? $loggedUser->id : 'null'
        ]);
        
        // ✅ Verificar sessão no banco
        $sessionId = session()->getId();
        $sessionData = DB::table('sessions')->where('id', $sessionId)->first();
        Log::info('Sessão no banco:', [
            'session_id' => $sessionId,
            'user_id_na_sessao' => $sessionData->user_id ?? 'null'
        ]);

        Log::info('Redirecionando para dashboard...');

        return redirect()->intended(route('dashboard', absolute: false));
        
    } catch (\Exception $e) {
        Log::error('Erro no login:', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);

        throw $e;
    }
}
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logout realizado com sucesso!');
    }
}
