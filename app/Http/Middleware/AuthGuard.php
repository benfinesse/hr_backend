<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\User;
use Closure;

class AuthGuard
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
        $uToken = $request->header('User-Token');

        $user = Admin::where('token', $uToken)->where('active', true)->first();

        if(!empty($user)) {

            $time = $user->u_token_exp;
            if($time >= time()){
                //update time
                $timeleft = $time - time();
                $oneMonth = 2592000;
                if($timeleft < $oneMonth){
                    //update time
                    $data['u_token_exp'] = $oneMonth*2;
                    $user->update($data);
                }

                return $next($request);
            }
            return response()->json([
                'message'=>'Session Expired. Access Denied',
                'action'=>'login',
                'success'=>'no'
            ], 403);
        }

        return response()->json([
            'message'=>'Access Denied',
            'action'=>'login',
            'success'=>'no'
        ], 403);

    }
}
