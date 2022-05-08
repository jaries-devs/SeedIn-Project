<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
class AuthenticationController extends Controller
{

    public function register(Request $request){
        $fields = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|string|unique:admins,email',
            'mobile_number' => 'required|string',
            'role' => 'required|string',
            'password' => 'required|string|confirmed'

        ]);

        $admin = Admin::create([
            'first_name'=>$fields['first_name'],
            'last_name'=>$fields['last_name'],
            'address'=>$fields['address'],
            'email'=>$fields['email'],
            'mobile_number'=>$fields['mobile_number'],
            'role'=>$fields['role'],
            'password'=>bcrypt($fields['password'])

        ]);

        $token = $admin->createToken('myapptoken')->plainTextToken;

        $response = [
            'admin'=> $admin,
            'token'=> $token
        ];

        return response($response, 201);
    }

   public function logout(Request $request){
       auth()->user()->tokens()->delete();
       return [ 'message' => 'logout'
        ];
   }

    function showLogin()
    {
        return view('login');
    }

    function showRegister()
    {
        return view('register');
    }
}
