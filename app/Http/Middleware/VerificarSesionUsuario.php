<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarSesionUsuario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has("usuario_autenticado")) {
            // return abort(403, "Acceso no autorizado");
            return redirect()->to("http://127.0.0.1:8000/"); //* Url de login
        }

        return $next($request);
    }
}
