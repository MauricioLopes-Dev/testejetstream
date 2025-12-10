<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    // Mostra o formulário de login exclusivo para admins
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('dashboard');
        }

        return view('auth.admin-login');
    }

    // Processa o login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tenta logar APENAS se o papel for 'admin'
        // Isso impede que alunas ou mentoras usem essa tela
        if (Auth::attempt([
            'email' => $request->email, 
            'password' => $request->password, 
            'role' => 'admin'
        ], $request->filled('remember'))) {
            
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        // Se falhar (senha errada ou não é admin)
        throw ValidationException::withMessages([
            'email' => __('As credenciais não conferem ou você não tem acesso administrativo.'),
        ]);
    }

    // Logout específico do Admin
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}