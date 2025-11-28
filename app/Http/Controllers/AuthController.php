<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        // 1) LOGIN POR EMAIL
        if (Auth::attempt(['email' => $login, 'password' => $password])) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }

        // 2) ADMIN DO .ENV
        $adminEmail = env('ADMIN_EMAIL', 'admin@example.com');
        $adminPassword = env('ADMIN_PASSWORD', 'password');

        if ($login === $adminEmail && $password === $adminPassword) {

            $user = \App\Models\User::firstOrCreate(
                ['email' => $adminEmail],
                ['name' => 'Admin', 'password' => Hash::make($adminPassword)]
            );

            if (!Hash::check($adminPassword, $user->password)) {
                $user->password = Hash::make($adminPassword);
                $user->save();
            }

            Auth::login($user);

            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors([
            'login' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->withInput($request->only('login'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
