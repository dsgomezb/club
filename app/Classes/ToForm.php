<?php

namespace App\Classes;

trait ToForm
{
    public static function toSelect($value='value', $firsOption=[])
    {
        return $firsOption + self::orderBy($value)->pluck($value, 'id')->toArray();
    }
}
