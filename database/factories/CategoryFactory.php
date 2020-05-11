<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->word,
        'description' => $faker->sentence,
        'image' => $faker->imageUrl(120, 120),
        'banner' => $faker->imageUrl(640, 160),
    ];
});
