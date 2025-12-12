<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }

        // Verificar que el usuario sea administrador
        $userType = strtolower(trim(Auth::user()->userType));
        
        if ($userType !== 'admin') {
            // Redirigir al panel del usuario con mensaje de error
            return redirect()->route('index')->with('error', 'No tienes permisos para acceder a esta página. Solo administradores.');
        }

        return $next($request);
    }
}
