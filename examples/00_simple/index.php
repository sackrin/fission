<?php

/**
 * 00. SIMPLE FISSION SCHEMA EXAMPLE
 * Create a simple atom schema and hydrate with values to produce a processed array of data
 */

include('../../vendor/autoload.php');

use Fission\Reactor;
use Fission\Atom;
use Fission\Nucleus\Nucleus;
use Fission\Support\Press;
use Fission\Support\Type;
use Fission\Walker\Values;

// Create a new Atom instance
// This will hold the object schema
$atom = Atom::create('person');

// Create some fields to be added to the schema
// These are called nucleus and describe schema properties
$nuclei = [
    // Each nucleus has a machine name
    // Think of these as form field names
    Nucleus::create('first_name')
        // Types help determine how each nucleus will handle hydration
        ->type(Type::string())
        // Nucleus instances can have additional meta values
        // These might be useful for creating forms, conducting validation etc
        ->label('First Name'),
    Nucleus::create('last_name')
        ->type(Type::string())
        ->label('Last Name')
];

// Inject the nucleus instances into the atom
// The collective of nucleus is nuclei (just fyi)
$atom->nuclei($nuclei);

// The reactor instance is used to react the atom schema with the nuclei against data
// This is where you will get a hydrated object tree of data
$reactor = Reactor::using($atom);
// Reactors will output a tree of isotopes using the with method
// Isotopes are the hydrated form of a nucleus instance and contain values
// Sanitization, Validation and Policy rules are applied to isotopes
// Press is a util class used to combine and supply data to the reactor instance
// You can just use a standard array if you like
$isotopes = $reactor->with(Press::values([
        'first_name' => 'John',
        'last_name' => 'Doe'
    ]));
// Using the Values walker you can scrape the data from the isotope tree
// This will output a simple array tree representing the processed data
$values = Values::gather($isotopes)->all();

// This should display a nic simple tree of data : )
var_dump($values);