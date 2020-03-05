<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller{

    public function index(){
        $users = User::all();

        return response()->json(['data' => $users], 200);
    }


    public function store(Request $request){
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);

        return response()->json(['data' => $user], 201);

    }


    public function show($id){
        $user = User::findOrFail($id);
        return response()->json(['data' => $user], 200);
    }


    public function update(Request $request, $id){
        $user = User::findOrFail($id);
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];
    }

 
    public function destroy($id)
    {
        //
    }
}
