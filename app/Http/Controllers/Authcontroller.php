<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;
use DB;
use Hash;
use Session;

class Authcontroller extends Controller
{
    public function login()
    {
        
        return view('auth.login');
    }
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' =>  'required',
            'password'  =>  'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // echo '<pre>'; print_r($user); exit;
            return redirect()->route('dashboard')->with('success', 'Welcome to Dashboard');
        }

        return redirect()->route('login')->with('error', 'Login details are not valid');
    }
}
