<?php

namespace App\Http\Middleware;

use Closure, Session;

class AdminGuard
{
    public function handle($request, Closure $next)
    {
        if (Session::has('is_admin')) {
            return $next($request);
        } else {
            return redirect('user/signin');
        }
    }
}
