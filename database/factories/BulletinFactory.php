<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Bulletin;
use Faker\Generator as Faker;

$factory->define(Bulletin::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'title' => $faker->text(40),
        'description' => $faker->text(512),
        'phone' => $faker->numerify("+1 (###) ###-####"),
        'country' => $faker->country,
        'email' => $faker->email,
        'valid_to' => date('Y-m-d H:i:s', strtotime("+30 days")),
        'image' => null
    ];
});