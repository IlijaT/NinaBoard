<?php

use Faker\Generator as Faker;

$factory->define(App\Permission::class, function (Faker $faker) {
    return [
        'name'  => 'delete-project',
        'label' => 'Permission to delete a project',
    ];
});
