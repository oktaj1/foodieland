<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomAuthenticate
{
    protected function redirectTo($request)
    {
        dd('hre');
        if (!$request->expectsJson()) {
            return route('api.unauthenticated'); 
        }
    }
}
