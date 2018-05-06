<?php
use moki74\LaravelBtc\Models\Payment;
use Denpa\Bitcoin\Client as BitcoinClient;

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
            return resolve(BitcoinClient::class)->getnewaddress();
        },
        'paid' => 0,
        'amount' => 0,
        'confirmations' => 0,
    ];
});
