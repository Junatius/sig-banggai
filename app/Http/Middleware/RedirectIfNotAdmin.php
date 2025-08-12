<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login.admin')->withErrors(['akses' => 'Silakan login sebagai admin terlebih dahulu.']);
        }

        return $next($request);
    }
}
