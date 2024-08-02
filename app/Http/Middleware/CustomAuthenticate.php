<?php

namespace App\Http\Middleware;

// TODO: delete this file not needed
class CustomAuthenticate
{
    protected function redirectTo($request)
    {
        dd('hre');
        if (! $request->expectsJson()) {
            return route('api.unauthenticated');
        }
    }
}
