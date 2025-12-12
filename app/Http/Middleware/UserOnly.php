<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserOnly
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

        // Verificar que el usuario sea EXCLUSIVAMENTE usuario normal (pasajero)
        $userType = strtolower(trim(Auth::user()->userType));
        
        if ($userType !== 'user') {
            // Redirigir al panel con mensaje de error
            return redirect()->route('index')->with('error', 'No tienes permisos para acceder a esta página. Solo usuarios normales.');
        }

        return $next($request);
    }
}
