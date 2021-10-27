<?php

namespace App\Http\Middleware;

use Closure;

class Api
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
        //ensure routes are authenticated
        $header_guard = $request->header('Auth-Guard');

        $auth_guard = env('AUTH_GUARD');
        dd($auth_guard, $header_guard);
        if($header_guard===$auth_guard){
            return $next($request);
        }
        return response()->json([
            'message'=>'Bad Request',
            'action'=>'refresh',
            'success'=>'no'
        ], 400);
    }
}
