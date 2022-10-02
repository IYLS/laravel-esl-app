<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class StudentLoggedIn
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == "student")
        {
            return $next($request);
        }

        return redirect()->route('auth.index');
    }
}
