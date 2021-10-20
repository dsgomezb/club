<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Calification;
use App\Payment;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Calification::class, function (Faker $faker) {
    return [
    	'stars'=>rand(1,5),
        'author_id'=>rand(1,40),
    ];
});
