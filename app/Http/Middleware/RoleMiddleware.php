<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            abort(403);
        }

        $userRole = Auth::user()->role;

        if (!in_array($userRole, $roles)) {
            abort(403); // atau redirect ke halaman "Tidak Diizinkan"
        }

        return $next($request);
    }
}
