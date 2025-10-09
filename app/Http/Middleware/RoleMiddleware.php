<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $roles = is_array($roles) ? $roles : explode('|', $roles);

        if (!in_array(Auth::user()->role, $roles)) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
