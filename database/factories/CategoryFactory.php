<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Models\Category::class, function (Faker $faker) {
    return [
        'store_id' => 0,
        'title' => "[栏目]" . $faker->name,
        'keywords' => "[关键字]{$faker->word()}",
        'description' => "[介绍]{$faker->word()}",
        'parent_id' => 0,
        'type' => 0,
        'url' => null,
        'status' => 1,
    ];
});
