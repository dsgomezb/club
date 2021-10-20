<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class KameForm extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'kameform';
    }
}
