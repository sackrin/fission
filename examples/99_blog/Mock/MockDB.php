<?php

namespace Fission\Example\Mock;

use Faker\Factory;

class MockDB {

    public static function post() {
        // Create a new faker factory
        $faker = Factory::create();
        // Generate a consistent title
        $title = $faker->words(rand(3, 8), true);

        return [
            'id' => $faker->uuid,
            'slug' => str_replace(' ', '-', strtolower($title)),
            'title' => ucwords($title),
            'summary' => ucfirst($faker->paragraph),
            'authors' => [
                static::author(),
                static::author()
            ]
        ];
    }

    public static function author() {
        // Create a new faker factory
        $faker = Factory::create();

        return [
            'id' => $faker->uuid,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->email
        ];

    }

}