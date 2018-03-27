<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function __construct()
    {
        $this->middleware('guest',['except'=>'logout']);

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */

    public function showLoginForm()
    {

        return view ('auth/login',['title'=>'Credissimo - Log in']);
    }

    public function postLogin(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ]);
        $data = $request->only('email','password');
        if(Auth::attempt($data)){

            // check if user is admin
            if(Auth::check() && Auth::user()->isAdmin()){
                return redirect('/admin');
            }
            return redirect()->intended('/home');
        }
        return redirect()->back()->with(['not_found'=>"Wrong email or password.  Try again!"])->withInput();
    }

    public function logout()
    {
        if(!Auth::check()){
            return redirect('/login');
        }

        Auth::logout();
        return redirect()->route('home');
    }
}
