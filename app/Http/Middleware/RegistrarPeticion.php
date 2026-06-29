<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrarPeticion
{
    public function handle(Request $request, Closure $next): Response
    {
        $inicio = microtime(true);

        $response = $next($request);

        $tiempo = round((microtime(true) - $inicio) * 1000, 2);

        \Log::info('Petición registrada', [
            'metodo' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'tiempo' => $tiempo . 'ms',
            'status' => $response->getStatusCode(),
        ]);

        return $response;
    }
}