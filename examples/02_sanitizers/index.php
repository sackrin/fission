<?php

/**
 * 02. VALUE SANITIZERS
 * This example extends previous examples
 * Use inbuilt sanitizer to sanitize data
 */

include('../../vendor/autoload.php');

use Fission\Hydrate\Reactor;
use Fission\Schema\Atom;
use Fission\Schema\Nucleus;
use Fission\Schema\Policy\Allow;
use Fission\Schema\Policy\Deny;
use Fission\Sanitizer\GUMPSanitizer;
use Fission\Support\Press;
use Fission\Support\Type;
use Fission\Walker\Values;

$atom = Atom::create('person')
    ->roles(['owner','administrator','user'])
    ->scope(['r','w']);

$nuclei = [
    Nucleus::create('first_name')
        ->type(Type::string())
        ->label('First Name')
        ->sanitizers([
            // Sanitizers are used to sanitize (clean) values as they are injected into an isotope instance
            // Sanitizers are always run upon injection
            // You can have multiple sanitizers by adding more to the nucleus sanitizers array
            // Sanitizers will work in the order they appear within the nucleus sanitizers array
            // The bundled sanitizer uses the Wixel/GUMP library but feel free to build your own!
            GUMPSanitizer::using("trim|sanitize_string")
        ])
        ->policies([
            Deny::for("*")->scope("*"),
            Allow::for(["administrator","owner"])->scope(["r","w"]),
            Allow::for("user")->scope(["r"])
        ]),
    Nucleus::create('last_name')
        ->type(Type::string())
        ->label('Last Name')
        ->sanitizers([
            GUMPSanitizer::using("trim|sanitize_string")
        ])
        ->policies([
            Deny::for("*")->scope(["r","w"]),
            Allow::for("user")->scope(["r","w"])
        ])
];

$atom->nuclei($nuclei);

$reactor = Reactor::using($atom)
    ->roles(['user'])
    ->scope(['w','r']);

$isotopes = $reactor->with(Press::values([
    // Value has additional spaces which will be stripped out
    'first_name' => ' John ',
    'last_name' => 'Doe'
]));

$values = Values::gather($isotopes)->all();

var_dump($values);
