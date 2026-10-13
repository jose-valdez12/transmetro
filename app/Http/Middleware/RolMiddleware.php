<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Verificar que exista una sesión activa
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Verificar que el usuario esté activo
        if (!auth()->user()->estado) {
            abort(403, 'Su cuenta está desactivada.');
        }

        // Verificar si el usuario tiene un rol permitido
        if (!in_array(auth()->user()->rol, $roles, true)) {
            abort(403, 'No tiene permisos para acceder a este módulo.');
        }

        return $next($request);
    }
}
