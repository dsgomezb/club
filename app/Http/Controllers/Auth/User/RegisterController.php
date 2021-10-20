<?php

namespace App\Http\Controllers\Auth\User;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/perfil/verificacion-pendiente';

    public function __construct()
    {
        $this->middleware('guest:user');
    }

    protected function validator(array $data)
    {
        session()->flash('register', 'true');
        return Validator::make($data,
            [
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                'reason' => ['required', 'string', 'min:6'],
                'reference' => ['required', 'string', 'min:6'],
            ],
            [],
            [
                'username' => 'nombre de usuario',
                'password' => 'contraseña',
                'reason' => 'razón',
                'reference' => 'referencia',
            ]
        );
    }

    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'reason' => $data['reason'],
            'reference' => $data['reference'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function showRegistrationForm()
    {
        return view('front.auth.register');
    }

    protected function guard()
    {
       return \Auth::guard('user');
    }
}
