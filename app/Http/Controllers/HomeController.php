<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function links(){
        $headers = [
            "Auth-Guard"=>env('AUTH_GUARD'),

        ];
        $data = [
            "home"=>route('home'),
            "App Token"=>[
                "key"=>"Auth-Guard",
                "value"=>env('AUTH_GUARD'),
                "example" => $headers
            ],
            "User Token"=>[
              "User-Token"=>"token from login response"
            ],
            "Note"=>[
                "1"=>"All request must have the application token described above on its header for it to respond else a bad request",
                "2"=>"All secured routes must have the User-Token as part of the header request (given when login is successful) and the app token on the header for it to respond to any requests",
            ],
            "Authentication"=>[
                "login"=>[
                    "url"=>"",
                    "method"=>"post",
                    "header"=>$headers,
                    "params"=>[
                        "email",
                        "password",
                    ]
                ],
                "register"=>[],
            ],
            "Secured Routes"=>[
                "Users Links" => [
                    'all users' => [
                        'dashboard/users | GET ',
                        route('users.index')

                    ],
                    'single user' => 'dashboard/users/{uuid} | GET',
                    'create user' => [
                        'link'=>'dashboard/users | POST',
                        'params' => [
                            'first_name | required',
                            'last_name | required',
                            'email | required',
                            'password | required',
                            'phone',
                            'dob',
                            'image',
                            'address',
                        ]
                    ],
                    'update user' => [
                        'link'=>'dashboard/users/{uuid} | PUT || PATCH',
                        'params' => [
                            'first_name | required',
                            'last_name | required',
                            'email | required',
                            'phone',
                            'dob',
                            'image',
                            'address',
                        ]
                    ]
                ],
                "Admin Links" => [
                    'all admin' => [
                        'dashboard/admins | GET ',
                        route('admins.index')

                    ],
                ],
            ],


        ];
        return response()->json($data);
    }
}
