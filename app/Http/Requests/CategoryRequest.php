<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return \Auth::check();
    }

    public function rules()
    {
        $rules = [
            'value' => 'required|max:255'
        ];
        
        return request()->ajax() ? [] : $rules;
    }

    public function attributes()
    {
        return [
            'value' => 'Nombre de categoría',
        ];
    }
}
