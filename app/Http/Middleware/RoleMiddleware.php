<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        // Supongamos que tienes relación usuario->roles y método hasRole()
        if (!$user->hasRole($role)) {
            return response()->json(['message' => 'No autorizado, rol requerido: ' . $role], 403);
        }

        return $next($request);
    }
}
