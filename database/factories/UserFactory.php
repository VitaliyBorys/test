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

$factory->define(App\User::class, function (Faker $faker) {
    $gender = array_random(['f', 'm']);

    return [
        'name' => $gender == 'm' ? $faker->firstNameMale : $faker->firstNameFemale,
        'lastname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'confirmed' => (int)$faker->boolean,
        'phone' => $faker->phoneNumber,
        'birthday' => $faker->dateTimeBetween('-70 years', '-18 years'),
        'gender' => $gender,
        'created_at' => $faker->dateTimeBetween('-400 days', '+1 days')->format('Y-m-d'),
        'card' => $faker->creditCardNumber
    ];
});