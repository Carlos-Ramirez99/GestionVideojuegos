<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;



class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado y es admin
        if (auth()->check() && auth()->user()->isAdmin()) {
            return $next($request);
        }

        // Si no es admin, redirigir a home o mostrar error
        return redirect('/')->with('error', 'No tienes permisos para acceder a esta página.');
    }
}
