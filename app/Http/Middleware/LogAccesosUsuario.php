<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogAccesosUsuario
{
    public function handle(Request $request, Closure $next)
    {
        $usuario = Auth::user();

        if ($usuario) {
            Log::info("Acceso usuario ID {$usuario->id} a la ruta {$request->path()} a las " . now());
        }

        return $next($request);
    }
}
// Este middleware registra los accesos de los usuarios en el log de Laravel.
