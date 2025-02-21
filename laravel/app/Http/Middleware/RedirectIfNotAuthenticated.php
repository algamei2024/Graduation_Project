<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return $next($request);
            }
        }

        // Redirect based on the last guard
        $guard = end($guards);

        if ($guard === 'trader') {
            return redirect()->route('trader.login');
        } elseif ($guard === 'admin') {
            return redirect()->route('login');
        }

        return redirect('/login'); // Default redirect if no guard matches
    }
}