<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->must_change_password) {
            // autoriser l'accès aux routes de changement de mot de passe et au logout
            if ($request->routeIs('password.change') ||
                $request->routeIs('password.change.update') ||
                $request->routeIs('logout') ||
                $request->is('password/*')) {
                return $next($request);
            }

            return redirect()->route('password.change');
        }

        return $next($request);
    }
}