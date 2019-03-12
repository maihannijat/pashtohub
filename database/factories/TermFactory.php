<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Faker\Generator as Faker;

$factory->define(App\Models\Term::class, function (Faker $faker) use ($factory) {
    return [
        'term' => $faker->word,
        'lang_id' => $faker->numberBetween(1, 2),
        // 'user_id' => App\Models\User::inRandomOrder()->get()->id, // $factory->create(App\User::class)->id
        'user_id' => $faker->unique()->numberBetween(1, App\Models\User::count()),
        'nativity_scale' => $faker->numberBetween(1, 5),
        'lang_part_id' => $faker->numberBetween(1, 9),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime
    ];
});