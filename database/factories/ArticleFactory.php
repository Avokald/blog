<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->text,
        'status' => Article::STATUS_PUBLISHED,
        'user_id' => 2,
        'category_id' => 1,
        'tags' => ['a', 'b', 'c'],
    ];
});
