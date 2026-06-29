<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SoloCelular
{
    public function handle(Request $request, Closure $next): Response
    {
        $userAgent = $request->header('User-Agent', '');

        $esMovil = preg_match('/Mobile|Android|iPhone|iPad|iPod/i', $userAgent);

        if ($esMovil && !$request->is('movil')) {
            return redirect('/movil');
        }

        return $next($request);
    }
}