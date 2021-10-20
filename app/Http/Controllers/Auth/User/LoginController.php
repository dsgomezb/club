<?php

namespace App\Http\Controllers\Auth\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest:user')->except('logout');
    }

    public function showLoginForm()
    {
        return view('front.auth.login');
    }

    protected function validateLogin(Request $request)
    {
        session()->flash('login', 'true');
        $request->validate(
            [
               'email' => 'required|exists:users',
               'password' => 'required',
            ],
            [
                'email.required' => 'El usuario es obligatorio',
                'email.exists' => 'Credenciales incorrectas',
                'password.required' => 'La contraseña es requerida para logearse',
            ]
        );
    }

    protected function guard()
    {
       return \Auth::guard('user');
    }

    /*
    public function username()
    {
        return 'username';
    }
    */
}
