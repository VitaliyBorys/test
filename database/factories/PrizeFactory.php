<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Prize::class, function (Faker $faker) {
    $images = ['sport','car','people','meat','food','beach','php','iphone','news','studens','js'];
    return [
        'title' => $faker->sentence(),
        'poster' => 'https://source.unsplash.com/550x300/?'.array_rand($images,1),
        'created_at' => $faker->dateTimeBetween('-400 days', '+1 days')->format('Y-m-d'),
        'status' => \App\Models\Prize::AVAILABLE
    ];
});
