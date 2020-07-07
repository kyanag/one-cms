<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Member::class, function (Faker $faker) {
    return [
        'store_id' => intval(round(rand(0, 1))),
        'name' => $faker->name,
        'mobile' => $faker->phoneNumber,
        'remark' => $faker->text(10)
    ];
});
