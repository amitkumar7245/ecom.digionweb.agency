<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Login()
    {
        // dd(Hash::make(12345678));
        if (!empty(Auth::check())) {
            if (Auth::user()->role == "admin") {
                return redirect('admin/dashboard');
            } else if (Auth::user()->role == "vendor") {
                return redirect('vendor/dashboard');
            }
        }

        return view('auth.login');
    }

    public function AuthLogin(Request $request)
    {
        // dd($request->all());
        $remember = !empty($request->remember) ? true : false;

        if (Auth::attempt(['email' => $request, 'password' => $request->password], $remember)) {
            if (Auth::user()->role == "admin") {
                return redirect('admin/dashboard');
            } else if (Auth::user()->role == "vendor") {
                return redirect('vendor/dashboard');
            }
        } else {
            return redirect()->back()->with('error', 'Please enter the currect email and password');
        }
    }

    public function AuthLogout()
    {
        Auth::logout();

        return redirect(url('/login'));
    }
}
