<?php

use App\Payment;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTimeBetween('-5 days', '+30days')->format('Y-m-d'),
        'price' => 450,
        'updated_at' => $faker->dateTimeBetween('-5 days', '+30days')->format('Y-m-d'),
    ];
});
