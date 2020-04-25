<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->text,
        'status' => Post::STATUS_PUBLISHED,
        'user_id' => 2,
        'category_id' => 1,
        'tags' => ['a', 'b', 'c'],
    ];
});
