<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // $guard = Auth::guard()->getName();
        //      // تحقق من اسم الـ guard
        //      if ($guard == 'trader') {
        //         return route('trader.login'); // صفحة تسجيل دخول التجار
        //      }
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}