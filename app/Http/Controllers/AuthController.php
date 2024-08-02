<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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

    public function AuthForgot()
    {
     return view('auth.forgot');
    }

    public function StoreForgot(Request $request)
    {
    //    dd($request->all());
       $user = User::getEmailSingle($request->email);
       if(!empty($user))
         {
             $user->remember_token = Str::random(30);
             $user->save();
             Mail::to($user->email)->send(new ForgotPasswordMail($user));
 
             return redirect()->back()->with('success','Please check your email and reset your password');
         }
         else
         {
             return redirect()->back()->with('error','Email Not Found in the database');
         }
    }
    
    public function Reset($remember_token)
    {
       $user = User::getTokenSingle($remember_token);
       if(!empty($user))
       {
           $data['user'] = $user;
           return view('auth.reset',$data);
       }
       else
       {
        abort(404);
       }
    }

    public function PostReset($token, Request $request)
   {
      if($request->password == $request->cpassword)
      {
         $user = User::getTokenSingle($token);
         $user->password = Hash::make($request->password);
         $user->remember_token = Str::random(50);
         $user->save();

         return redirect('/login')->with('success', 'Password Successfully Reset');
      }
      else
      {
          return redirect('')->with('error','Password and confirm password does not match');
      }
   }

    public function AuthLogout()
    {
        Auth::logout();

        return redirect(url('/login'));
    }
}
