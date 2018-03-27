<?php

/**
 * 00. SIMPLE FISSION SCHEMA EXAMPLE
 * Create a simple atom schema and hydrate with values to produce a processed array of data
 */

include('../../vendor/autoload.php');

use Fission\Hydrate\Reactor;
use Fission\Schema\Atom;
use Fission\Schema\Nucleus;
use Fission\Support\Press;
use Fission\Support\Type;
use Fission\Walker\Values;

// Create a new Atom instance
// This will hold the object schema
$atom = Atom::create('person');

$nuclei = [
    Nucleus::create('first_name')
        ->type(Type::string())
        ->label('First Name'),
    Nucleus::create('last_name')
        ->type(Type::string())
        ->label('Last Name')
];

$atom->nuclei($nuclei);

$reactor = Reactor::using($atom);
$isotopes = $reactor->with(Press::values([
        'first_name' => 'John',
        'last_name' => 'Doe'
    ]));
$values = Values::gather($isotopes)->all();

var_dump($values);