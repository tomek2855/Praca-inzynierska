<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Issue;
use Faker\Generator as Faker;

$factory->define(Issue::class, function (Faker $faker) {
    return [
        'title' => $faker->text(),
        'content' => $faker->text(1000),
    ];
});
