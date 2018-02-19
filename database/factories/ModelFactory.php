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

$factory->define(App\User::class, function (Faker\Generator $faker){
    return [
        'name' => $faker->name('male'),
        'email' => 'egor.admin@gmail.com',
        'type' => 'admin',
        'phone' => '380665290379',
        'password' => bcrypt('123')
    ];
});

$factory->define(App\Events::class, function (Faker\Generator $faker) {

    return [
        'uid' => $faker->uuid,
        'title' => $faker->jobTitle,
        'date' => $faker->date('d-m-Y'),
        'place' => $faker->city

    ];
});

$factory->define(App\Laps::class, function (Faker\Generator $faker) {

    return [
        'uid' => $faker->uuid,
        'title' => $faker->jobTitle,
        'price' => $faker->randomFloat(2,1,1000),
        'participants_limit' => $faker->randomNumber(3),
        'event_id' => function () {
        return factory(App\Events::class)->create()->id;
    }
    ];
});

$factory->define(App\PromoCodes::class, function (Faker\Generator $faker) {

    return [
        'uid' => $faker->uuid,
        'promo_code' => $faker->randomDigitNotNull,
        'discount_percent' => $faker->randomDigit,
        'used' => $faker->boolean(),
        'lap_id' => function() {
            return factory(\App\Laps::class)->create()->id;
        }
    ];
});



//$factory->define(App\Participants::class, function (Faker\Generator $faker) {
//
//    $user =
//    return [
//        '' return factory(\App\Groups::class)->create()->id;
//    ];
//});