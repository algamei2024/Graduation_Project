<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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

        //الكود الجديد

        // if(!Auth::guard('admin')->check()){
        //     return redirect('admin/login');
        // }
        // return $next($request);

        //الكود القديم
        if ($request->user()->role == 'admin') {
            return $next($request);
        } else {
            if ($request->isJson() || $request->wantsJson()) {
                return response()->json(
                    [
                        'error' => 'ليس لديك صلاحية الوصول إلى هذه الصفحة.',
                    ],
                    403
                );
            } else {
                request()
                    ->session()
                    ->flash(
                        'error',
                        'You do not have any permission to access this page'
                    );
                return redirect()->route($request->user()->role);
            }
        }
    }
}