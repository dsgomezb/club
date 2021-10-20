<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\AppController;

class CategoryController extends AppController
{
    protected $class = Category::class;
    protected $viewFolder = 'admin.categories';
    protected $needAuthorization = false;
}
