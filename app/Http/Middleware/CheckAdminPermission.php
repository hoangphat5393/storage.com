<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd('CheckAdminPermission');
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->admin_level == 99999) {
            return $next($request);
        } else {
            return redirect()->route('adminError');
        }
    }
}
