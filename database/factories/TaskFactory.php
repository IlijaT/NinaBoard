<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'title'      => $faker->sentence,
        'start'      => $start = Carbon::now(),
        'end'        => $start->addHour(),
        'project_id' => factory(App\Project::class),
        'completed'  => false
    ];
});
