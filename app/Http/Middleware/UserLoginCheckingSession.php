<?php

namespace App\Http\Middleware;

use Closure;

class UserLoginCheckingSession{

    public function handle($request, Closure $next)
    {
        if ($request->session()->exists('username')) {
            
            return back();
        }

        return $next($request);
    }
}