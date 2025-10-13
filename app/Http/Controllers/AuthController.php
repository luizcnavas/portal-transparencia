<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
	 * Primeiro tenta autenticar por email+senha. Se falhar, mantém o
	 * fallback de desenvolvimento (login:admin / password:admin) que
	 * autentica o primeiro usuário disponível. Como garantia, se o
	 * usuário informar admin@example.com/password e ele não existir,
	 * é criado automaticamente.
	 */
	public function login(Request $request)
	{
		$request->validate([
			'login' => ['required', 'string'],
			'password' => ['required', 'string'],
		]);

		$login = $request->input('login');
		$password = $request->input('password');

		// 1) Autenticação padrão por email+senha
		if (str_contains($login, '@')) {
			if (Auth::attempt(['email' => $login, 'password' => $password])) {
				$request->session()->regenerate();
				return redirect()->intended('admin/dashboard');
			}

			// Garantia: criar admin padrão se solicitado e ainda não existir
			if ($login === 'admin@example.com' && $password === 'password') {
				$user = \App\Models\User::firstOrCreate(
					['email' => 'admin@example.com'],
					['name' => 'Admin', 'password' => Hash::make('password')]
				);
				Auth::login($user);
				$request->session()->regenerate();
				return redirect()->intended('admin/dashboard');
			}
		}

		// 2) Fallback simplificado de desenvolvimento
		if ($login === 'admin' && $password === 'admin') {
			$user = \App\Models\User::first();
			if ($user) {
				Auth::login($user);
				$request->session()->regenerate();
				return redirect()->intended('admin/dashboard');
			}
		}

		return back()->withErrors([
			'login' => 'As credenciais fornecidas não correspondem aos nossos registros.',
		]);
	}

	/**
	 * Faz logout do usuário.
	 */
	public function logout(Request $request)
	{
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect('/');
	}
}