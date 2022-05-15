<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AuthenticationController extends Controller
{

    public function register(Request $request){

        $fields = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|string|unique:admins,email',
            'mobile_number' => 'required|string',
            'role' => 'string',
            'password' => 'required|string'
        ]);

        $admin = Admin::create([
            'first_name'=>$fields['first_name'],
            'last_name'=>$fields['last_name'],
            'address'=>$fields['address'],
            'email'=>$fields['email'],
            'mobile_number'=>$fields['mobile_number'],
            'role'=>  'User',
            'password'=>bcrypt($fields['password'])
        ]);

        $token = $admin->createToken('myapptoken')->plainTextToken;

        $response = [
            'admin'=> $admin,
            'token'=> $token
        ];

        return response($response, 201);
    }

   public function login(Request $request){

    $fields = $request->validate([
        'email' => 'required|string',
        'password' => 'required|string'
    ]);

    $admin = Admin::where('email', $fields['email'])->first();
    if(!$admin || !Hash::check($fields['password'], $admin->password)){
        return response([
            'message' => 'Incorrect Email or Password'
        ], 401);
    }


    $token = $admin->createToken('myapptoken')->plainTextToken;

    $_SESSION["jwt"] = $token;
    $_SESSION["user"] = $admin->id;

    $response = [
        'admin'=> $admin,
        'token'=> $token
    ];

    return response($response, 201);
    return redirect('dashboard');
}

public function logout(Request $request){
    session_destroy();
   auth()->user()->tokens()->delete();
   return [
        'message' => 'logout'
    ];
}
    // public function logout(Request $request)
    // {
    //     Admin::logout();

    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();

    //     return redirect('login');
    // }

    function showLogin()
    {
        return view('login');
    }

    function showRegister()
    {
        return view('register');
    }

    public function showroles() {
        $user = Admin::where('id',$_SESSION["user"])->get();
        $roles = Role::all();
        $permission = Permission::all();



        $data = [
            'user' => $user[0],
            'admin' => Admin::all(),
            'roles' => $roles,
            'permission' => $permission
        ];


        return view('roles', compact('data'));
    }
}

