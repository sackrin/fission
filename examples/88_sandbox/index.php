<?php

/**
 * 00. SIMPLE FISSION SCHEMA EXAMPLE
 * Create a simple atom schema and hydrate with values to produce a processed array of data
 */

include('../../vendor/autoload.php');

use Fission\Policy\Allow;
use Fission\Policy\Deny;
use Fission\Reactor;
use Fission\Atom;
use Fission\Nucleus\Nucleus;
use Fission\Sanitize\GUMPSanitizer;
use Fission\Support\Press;
use Fission\Support\Type;
use Fission\Validate\GUMPValidator;
use Fission\Walker\Validator;
use Fission\Walker\Values;

$atom = Atom::create('person');

$nuclei = [
    Nucleus::create('first_name')
        ->type(Type::string())
        ->label('First Name')
        ->policies([
            Deny::for("*")->scope("*"),
            Allow::for(["administrator","owner"])->scope(["r","w"]),
            Allow::for("user")->scope(["r"])
        ])
        ->sanitizers([
            GUMPSanitizer::using("trim|sanitize_string")
        ])
        ->validators([
            GUMPValidator::against("required|min_len,5")
        ])
];

$atom->nuclei($nuclei);

$reactor = Reactor::using($atom)
    ->roles(['user'])
    ->scope(['w','r']);

$isotopes = $reactor->with(Press::values([
    'first_name' => ' John '
]));

$validator = Validator::validate($isotopes);

if ($validator->hasErrors()) {
    echo "Oh No, Failed Validation!";
    $errors = $validator->errors();
    var_dump($errors);
} else {
    $values = Values::gather($isotopes)->all();
    echo "Everything Validated!";
    $values = Values::gather($isotopes)->all();
    var_dump($values);
}