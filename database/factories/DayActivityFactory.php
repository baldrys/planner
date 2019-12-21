<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DayActivity;
use App\User;
use App\UserActivity;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(DayActivity::class, function (Faker $faker) {
    return [
        "user_activity_id" => UserActivity::first() !== null ? $faker->randomElement(UserActivity::where('id' ,'>' ,0)->pluck('id')->toArray()) :  factory(App\UserActivity::class)->create()->id,
        "is_done" => $faker->boolean,
        "is_free_day" => $faker->boolean,
        "date" => date('Y-m-d', time())
    ];
});
