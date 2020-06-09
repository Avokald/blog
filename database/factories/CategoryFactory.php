<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->word,
        'description' => $faker->sentence,
        'image' => '/images/door.png', // $faker->imageUrl(120, 120),
        'banner' => '/images/banner.jpg', // $faker->imageUrl(640, 160),
    ];
});
