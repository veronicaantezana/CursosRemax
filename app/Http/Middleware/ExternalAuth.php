<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExternalAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado via sesión
        if (!session('external_auth') || !session('user')) {
            return redirect('/login');
        }

        return $next($request);
    }
}