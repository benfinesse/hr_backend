<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\General\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use Utility;
    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');

        $credentials = [
            'email'=>$email,
            'password'=>$password
        ];

        $admin = Admin::where('email', $email)->where('active', true)->first();
        if(!empty($admin)){

//            $auth = Hash::check("{$password}", "{$admin->password}");
            $auth = Auth::guard('admin')->attempt($credentials);

            if($auth){
                $oneMonth = 2592000;
                $data['u_token_exp'] = time()+$oneMonth*2;
                $data['token'] = $this->randomName(36);
                $admin->update($data);
                return response()->json([
                    'message'=>'success',
                    'data'=>[
                        'first_name'=>$admin->first_name,
                        'last_name'=>$admin->last_name,
                        'email'=>$admin->email,
                        'uuid'=>$admin->uuid,
                        'phone'=>$admin->phone,
                        'dob'=>$admin->dob,
                        'image'=>$admin->image,
                        'address'=>$admin->address,
                        'token'=>$admin->token,
                    ],
                    'success'=>'yes'
                ], 200);
            }
            return response()->json([
                'message'=>'Incorrect Credentials Given',
                'action'=>'retry',
                'success'=>'no'
            ], 403);
        }

        return response()->json([
            'message'=>'Account Not Found',
            'action'=>'retry',
            'success'=>'no'
        ], 403);
    }
}
