<?php

use Faker\Generator as Faker;
use App\Group;
use App\GroupStop;

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

$factory->define( Group::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'public' => 0
    ];
});

$factory->state( Group::class, 'public', function ($faker) use ($factory) {
    return ['public' => 1];
});

$factory->state( Group::class, 'private', function ($faker) use ($factory) {
    return ['public' => 0];
});

$factory->define( GroupStop::class, function (Faker $faker) {
    return [
        'lat' => 51.39358266870915,
		'lng' => -0.3036689758300781,
		'name' => $faker->name,
		'description' => $faker->sentence,
		'group_id' => function() {
			return factory( Group::class);
		}
    ];
});