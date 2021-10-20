<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsletterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|unique:newsletter'
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'El correo ya se encuentra registrado'
        ];
    }
}
