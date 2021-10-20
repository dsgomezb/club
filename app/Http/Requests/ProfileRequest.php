<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize()
    {
        return \Auth::guard('user')->check();
    }

    public function rules()
    {
        $validate = [
            'about'=>'required',
        ];

        if (request()->has("password")) 
            $validate['password'] = 'confirmed';
        
        return $validate;
    }

    public function attributes()
    {
        return [
            'about'=>'acerca de mí',
            'password'=>'contraseña',
            'password_confirmation'=>'confirmación de contraseña'
        ];
    }
}
