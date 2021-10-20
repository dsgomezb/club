<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize()
    {
        return \Auth::guard('user')->check();
    }

    public function rules()
    {
        return [
            'message' => 'required|min:3'
        ];
    }

    public function messages()
    {
        return [
            'message.required' => 'Debés ingresar un contenido para el mensaje',
            'message.min' => 'El mensaje es muy breve',
        ];
    }
}
