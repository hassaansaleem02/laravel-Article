<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fileds = $request->validate(
            [
                'name' => 'Required|string',
                'email' => 'required|string',
                'password' => 'required|string',
            ]
        );

        $user = User::create([
            'name' => $fileds['name'],
            'email' => $fileds['email'],
            'password' => bcrypt($fileds['password'])

        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    
    public function login(Request $request)
    {
        $fileds = $request->validate(
            [
                'email' => 'required|string',
                'password' => 'required|string',
            ]
        );

       $user= User::where('email', $fileds['email'])->first();
       
       if(!$user || !Hash::check($fileds['password'], $user->password))
       {
           
        $response=[
            'message'=>'bad request'
        ];

        return response($response,401);

       }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
    
    
    
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message'=>'Session logged out'
        ];
    }
}
