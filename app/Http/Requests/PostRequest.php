<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'category_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'título',
            'content' => 'cuerpo',
            'category_id' => 'categoría',
        ];
    }
}
