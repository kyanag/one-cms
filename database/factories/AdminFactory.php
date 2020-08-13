<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\User::class, function (Faker $faker) {
    return [
        'username' => $faker->userName,
        'nickname' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt("123456"), // secret
        'remember_token' => str_random(10),
    ];
});
