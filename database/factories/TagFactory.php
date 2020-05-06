<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    $words = $faker->words(random_int(1, 10));

    $title = "";
    foreach ($words as $word) {
        $title .= ucfirst($word);
    }

    return [
        'title' => $title,
    ];
});
