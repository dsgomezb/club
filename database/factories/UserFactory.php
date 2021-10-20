<?php

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    $emailVerified = rand(0, 1);
    
    return [
        'username' => $faker->unique()->firstname,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => $emailVerified == 1 ? $faker->dateTime : null,
        'is_banned' => $faker->boolean(20),
        'is_approved' => rand(0, 1),
        'password' => \Hash::make('123456'),
        'created_at' => $faker->dateTimeBetween('-90 days'),
        'about'=> $faker->paragraph,
        'stars'=>rand(1,5)
    ];
});
