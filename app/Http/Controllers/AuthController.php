<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Mostra o formulário de login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Trata tentativa de autenticação.
     *
     * Anotação: neste projeto há uma verificação simplificada de credenciais
     * (login:admin / password:admin) que, em dev, loga o primeiro usuário do
     * banco como administrador. Não usar em produção. Comentário apenas.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('login', 'password');

    // Verifica credenciais fixas (simplificado)
        if ($credentials['login'] === 'admin' && $credentials['password'] === 'admin') {
            // Login manual de um usuário (simplificado)
            // Usa o primeiro usuário disponível como admin
            $user = \App\Models\User::first();
            if ($user) {
                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->intended('admin/dashboard');
            }
            // Se não houver usuário, não conseguimos logar
            // Fallback para autenticação simplificada
        }

        return back()->withErrors([
            'login' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
    }

    /**
     * Faz logout do usuário.
     *
     * Anotação: invalida sessão e regenera token CSRF.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}