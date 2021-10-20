<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRequest extends FormRequest
{
    public function authorize()
    {
        return \Auth::guard('user')->check();
    }

    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'content' => 'required',
            'location' => 'required',
            'zone' => 'required',
            'minimum_investment' => 'required',
            'company' => 'required',
            'start' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'título',
            'content' => 'cuerpo',
            'location' => 'Locación',
            'zone' => 'Zona',
            'minimum_investment' => 'Inversión mínima',
            'company' => 'Empresa',
            'start' => 'Comienzo',
        ];
    }
}
