<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'excerpt' => $faker->text(120),
        'content' => $faker->text,
        'status' => Post::STATUS_PUBLISHED,
        'user_id' => UserSeeder::TEST_USER_ID,
        'category_id' => CategorySeeder::TEST_CATEGORY_ID,
        'tags' => ['a', 'b', 'c'],
    ];
});
