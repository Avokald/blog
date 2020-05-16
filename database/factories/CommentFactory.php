<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'content' => $faker->text,

        'user_id' => UserSeeder::TEST_USER_ID,
        'post_id' => PostSeeder::TEST_PUBLISHED_ID,
    ];
});
