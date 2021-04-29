<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Coordinate;
use Faker\Generator as Faker;


$factory->define(Coordinate::class, function (Faker $faker) {
    return [
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'bulletin_id' => factory(App\Models\Bulletin::class)
    ];
});