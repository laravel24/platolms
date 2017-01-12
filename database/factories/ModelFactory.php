<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
*/

// Users
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    $display = $firstName . ' ' . $lastName;

    return [
        'email' => $display . '@bobmail.info',
        'password' => $password ?: $password = bcrypt('secret'),
        'first' => $firstName,
        'last' => $lastName,
        'display_name' => $display,
        'bio' => $faker->text,
        'img' => $faker->imageUrl(200, 200, 'people', true, 'PlatoLMS', true),
        'question' => $faker->sentence,
        'answer' => $faker->word,
        'address' => $faker->streetAddress,
        'address_2' => $faker->secondaryAddress,
        'city' => $faker->city,
        'postal' => $faker->randomNumber(5),
        'state' => $faker->stateAbbr,
        'country' => $faker->country,
        'timezone' => $faker->timezone,
        'phone' => $faker->phoneNumber,
        'ip' => $faker->ipv4,
        'remember_token' => str_random(10),
    ];
});

// Posts
$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {

    $title = $faker->sentence(6,true);

    return [
        'title' => $title,
        'slug' => str_slug($title),
        'content' => $faker->text,
        'img' => $faker->imageUrl(800, 400, 'people', true, 'PlatoLMS', true),
        'video' => $faker->text,
    ];
});

// Pages
$factory->define(App\Models\Page::class, function (Faker\Generator $faker) {

    $title = $faker->sentence(6,true);

    return [
        'layout_id' => $faker->numberBetween(0,10),
        'title' => $title,
        'slug' => str_slug($title),
        'content' => $faker->text,
        'img' => $faker->imageUrl(800, 400, 'people', true, 'PlatoLMS', true),
        'video' => $faker->text,
    ];
});
