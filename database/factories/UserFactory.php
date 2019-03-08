<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
*/

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->email,
        'first_name' => $faker->firstNameMale,
        'last_name' => $faker->lastName,
        'status' => $faker->numberBetween($min = 1, $max = 4),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        // 'password_forgot_time' => $faker->dateTime,
        // 'token' => Str::random(64),
        'country_id' => $faker->numberBetween($min = 1, $max = 180),
        'phone' => $faker->unique()->numerify('##########'),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime
    ];
});