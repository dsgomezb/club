<?php

use App\Event;
use Carbon\Carbon;
use Faker\Generator as Faker;

$categories = \App\Category::select('id')->pluck('id');

$factory->define(\App\Post::class, function (Faker $faker) use ($categories) {
	$date = Carbon::instance($faker->dateTimeBetween('-120 days', '-5 days'));

    return [
        'title' => $faker->sentence,
        'slug' => \Str::slug($faker->sentence),
        'content' => $faker->paragraph,
        'published_at' => $date,
        'is_visible' => $faker->boolean(70),
		'category_id' => $categories->random(),
    ];
});
