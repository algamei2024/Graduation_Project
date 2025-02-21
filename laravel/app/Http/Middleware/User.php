<?php

namespace App\Http\Middleware;

use Closure;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $nameStore = $request->input('nameStore');
        if(empty(session('user'))){
            return redirect()->route('login.form',['nameStore'=>$nameStore]);
        }
        else{
            return $next($request);
        }
    }
}