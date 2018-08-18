<?php
use moki74\LaravelBtc\Models\Payment;

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




$factory->define(moki74\LaravelBtc\Models\Payment::class, function (Faker\Generator $faker) {
    return [
        'address' => function () {
            return resolve("bitcoind")->getnewaddress();
        },
        'paid' => 0,
        'amount' => $faker->randomFloat(4, 0.0001, 1.9999),
        'confirmations' => 0,
    ];
});
