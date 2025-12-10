<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Se não estiver logado, manda pro login de admin
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        // Se estiver logado mas NÃO for admin, proíbe (403)
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acesso não autorizado para esta área.');
        }

        return $next($request);
    }
}