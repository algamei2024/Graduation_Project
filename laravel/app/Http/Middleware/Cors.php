<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //يسمح لي بالارسال من مشروع رياكت بطريقة جت get
        // return $next($request)->header('Access-Control-Allow-Origin', '*');

        //يسمح لي بالارسال من مشروع رياكت بطريقة  get and post
        $response = $next($request);

        $response->header('Access-Control-Allow-Credentials', 'true');
        $response->header('Access-Control-Max-Age', '600'); // cache for 10 minutes

        $response->header(
            'Access-Control-Allow-Methods',
            'POST, GET, OPTIONS, DELETE, PUT'
        ); //Make sure you remove those you do not want to support

        $response->header(
            'Access-Control-Allow-Headers',
            'Content-Type, Accept, Authorization, X-Requested-With, Application'
        );
        $response->header('Access-Control-Allow-Origin', '*');

        return $response;
    }
}
