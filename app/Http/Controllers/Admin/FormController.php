<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Http\Controllers\Controller;

class FormController extends Controller
{
    private $map = [
        'category_id' => [
        	'class' => \App\Subcategory::class,
        	'val' => 'id',
        	'text' => 'value'
        ]
    ];

    public function toSelect()
    {
        extract(request()->only('name', 'value'));

        extract($this->map[$name]);

    	return $class::selectRaw("$val as val, $text as text")->where($name, $value)->get();
    }
}
