<?php

namespace App\Http\Middleware;

use Closure;

class UserCheckingSession{
    
    public function handle($request, Closure $next)
    {
        if (!$request->session()->exists('username')) {
            return redirect('/login');
        }

        return $next($request);
    }
}