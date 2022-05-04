<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    function showLogin()
    {
        return view('login');
    }

    function showRegister()
    {
        return view('register');
    }
}
