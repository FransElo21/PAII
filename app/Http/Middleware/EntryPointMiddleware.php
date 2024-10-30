<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntryPointMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('entry_point')->check()) {
            return redirect()->route('login.showLoginForm')->withErrors('Silahkan login terlebih dahulu menggunakan guard entry_point');
        }

        return $next($request);
    }
}
