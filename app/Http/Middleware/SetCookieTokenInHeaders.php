<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCookieTokenInHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('auth_token');
        if ($token) {
            $request->headers->set('Authorization', 'Bearer '.$token);
        }

        return $next($request);
    }
}