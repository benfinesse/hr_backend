<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function links(){
        $data = [
            "home"=>route('home'),
            "Users Links" => [
                'all users' => [
                    '/users | GET ',
                    route('users.index')

                ],
                'single user' => '/users/{uuid} | GET',
                'create user' => [
                    'link'=>'/users | POST',
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
                    'link'=>'/users/{uuid} | PUT || PATCH',
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
                    '/admins | GET ',
                    route('admins.index')

                ],
            ]
        ];
        return response()->json($data);
    }
}
