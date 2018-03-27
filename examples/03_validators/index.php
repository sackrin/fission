<?php

/**
 * 03. VALUE VALIDATION
 * This example extends previous examples
 */

include('../../vendor/autoload.php');

use Fission\Hydrate\Reactor;
use Fission\Schema\Atom;
use Fission\Schema\Nucleus;
use Fission\Schema\Policy\Allow;
use Fission\Schema\Policy\Deny;
use Fission\Sanitizer\GUMPSanitizer;
use Fission\Schema\Validator\GUMPValidator;
use Fission\Support\Press;
use Fission\Support\Type;
use Fission\Walker\Validator;
use Fission\Walker\Values;

$atom = Atom::create('person')
    ->roles(['owner','administrator','user'])
    ->scope(['r','w']);

$nuclei = [
    Nucleus::create('first_name')
        ->type(Type::string())
        ->label('First Name')
        ->sanitizers([
            GUMPSanitizer::using("trim|sanitize_string")
        ])
        ->validators([
            GUMPValidator::against("required|min_len,5")
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
        ->validators([
            GUMPValidator::against("required")
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
    'first_name' => ' John ',
    'last_name' => 'Doe'
]));

$validator = Validator::validate($isotopes);

$values = Values::gather($isotopes)->all();

if ($validator->hasErrors()) {
    echo "Oh No, Failed Validation!";
    $errors = $validator->errors();
    var_dump($errors);
} else {
    echo "Everything Validated!";
    $values = Values::gather($isotopes)->all();
    var_dump($values);
}
