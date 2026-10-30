<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class TeacherLoggedIn
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->role, ['teacher', 'researcher']))
        {
            return $next($request);
        }

        return redirect()->route('auth.index');
    }
}
