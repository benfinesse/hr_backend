<?php

namespace App\Http\Controllers;

use App\Traits\General\Utility;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use Utility;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::orderBy('id', 'desc')->paginate(20);
        return response()->json($user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $err = false;
        $error = array();
        $data = $request->all();


        if(empty($request->input('first_name')) || empty($request->input('last_name')) || empty($request->input('email'))){
            $err = true;
            array_push($error, "required fields are missing!");
        }

        if(!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
            $err = true;
            array_push($error, "Email not formatted properly");
        }
        $email = $request->input('email');
        $exist = User::where('email', $email)->first();
        if(!empty($exist)){
            $err = true;
            array_push($error, "A user with the email '{$email}' already exist.");
        }

        if(!empty($request->input('phone'))){
            if(!is_numeric($request->input('phone'))){
                $err = true;
                array_push($error, "Phone number not properly formatted");
            }
        }

        $password = !empty($request->input('password'))?bcrypt($request->input('password')):bcrypt($this->randomName(8));

        if(empty($request->input('password'))){
            //todo send email
        }

        $dob = $request->input('dob');
        if(!empty($dob)){
            $x = strtotime($dob);
            if($x!==false){
                $dob = $x;
            }else{
                $dob = null;
            }
        }

        if($err){

            return response()->json(['errors'=>$error,'message'=>'Could not complete request'], 500);
        }

        //create object
        $user['uuid'] = $this->makeUuid();
        $user["first_name"] = $request->input('first_name');
        $user["last_name"] = $request->input('last_name');
        $user["email"] = $request->input('email');
        $user["password"] = $password;
        $user["phone"] = $request->input('phone');
        $user["dob"] = date('Y-m-d', $dob);
        $user["address"] = $request->input('address');

        $acct = User::create($user);

        return response()->json(['message'=>'successful','user'=>$acct]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $user = User::whereUuid($uuid)->first();
        if(!empty($user)){
            return response()->json($user);
        }
        $data = [
            'message'=>'not found',
        ];
        return response()->json( $data,404);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {

        $err = false;
        $error = array();

        $user = User::where('uuid', $uuid)->first();
        if(empty($user)){
            $err = true;
            array_push($error, "account not found!");
        }

        if(empty($request->input('first_name')) || empty($request->input('last_name')) || empty($request->input('email'))){
            $err = true;
            array_push($error, "required fields are missing!");
        }

        if(!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
            $err = true;
            array_push($error, "Email not formatted properly");
        }
        $email = $request->input('email');
        $exist = User::where('email', $email)->where('uuid', '!=', $uuid)->first();
        if(!empty($exist)){
            $err = true;
            array_push($error, "A user with the email '{$email}' already exist.");
        }

        if(!empty($request->input('phone'))){
            if(!is_numeric($request->input('phone'))){
                $err = true;
                array_push($error, "Phone number not properly formatted");
            }
        }

        $dob = $request->input('dob');
        if(!empty($dob)){
            $x = strtotime($dob);
            if($x!==false){
                $dob = $x;
            }else{
                $dob = null;
            }
        }

        if($err){

            return response()->json(['errors'=>$error,'message'=>'Could not complete request'], 500);
        }

        //create object

        $data["first_name"] = $request->input('first_name');
        $data["last_name"] = $request->input('last_name');
        $data["email"] = $email;
        $data["phone"] = $request->input('phone');
        $data["dob"] = date('Y-m-d', $dob);
        $data["address"] = $request->input('address');

        $user->update($data);

        return response()->json(['message'=>'update successful','user'=>$user]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
