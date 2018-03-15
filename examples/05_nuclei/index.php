<?php

/**
 * 05. CHILD NUCLEI
 * This example extends previous examples
 */

include('../../vendor/autoload.php');

use Fission\Hydrate\Reactor;
use Fission\Schema\Atom;
use Fission\Schema\Formatter\FormatTo;
use Fission\Schema\Nucleus;
use Fission\Schema\Policy\Allow;
use Fission\Schema\Policy\Deny;
use Fission\Schema\Sanitizer\GUMPSanitizer;
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
        ->formatters([
            FormatTo::type('string')
        ])
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
        ->formatters([
            FormatTo::type('string')
        ])
        ->sanitizers([
            GUMPSanitizer::using("trim|sanitize_string")
        ])
        ->validators([
            GUMPValidator::against("required")
        ])
        ->policies([
            Deny::for("*")->scope(["r","w"]),
            Allow::for("user")->scope(["r","w"])
        ]),
    Nucleus::create('emails')
        ->type(Type::collection())
        ->label('Email Addresses')
        ->formatters([
            FormatTo::type('array')
        ])
        ->policies([
            Deny::for("*")->scope(["r","w"]),
            Allow::for("user")->scope(["r","w"])
        ])
        ->nuclei([
            Nucleus::create('label')
                ->type(Type::string())
                ->label('Label')
                ->formatters([
                    FormatTo::type('string')
                ])
                ->sanitizers([
                    GUMPSanitizer::using("trim|sanitize_string")
                ])
                ->validators([
                    GUMPValidator::against("required")
                ])
                ->policies([
                    Deny::for("*")->scope("*"),
                    Allow::for(["administrator","owner"])->scope(["r","w"]),
                    Allow::for("user")->scope(["r"])
                ]),
            Nucleus::create('address')
                ->type(Type::string())
                ->label('Address')
                ->formatters([
                    FormatTo::type('string')
                ])
                ->sanitizers([
                    GUMPSanitizer::using("trim|sanitize_email")
                ])
                ->validators([
                    GUMPValidator::against("required|valid_email")
                ])
                ->policies([
                    Deny::for("*")->scope("*"),
                    Allow::for(["administrator","owner"])->scope(["r","w"]),
                    Allow::for("user")->scope(["r"])
                ]),
        ])
];

$atom->nuclei($nuclei);

$reactor = Reactor::using($atom)
    ->roles(['user'])
    ->scope(['w','r']);

$isotopes = $reactor->with(Press::values([
    'first_name' => ' Johnny ',
    'last_name' => 'Smithy',
    'emails' => [
        [
            'label' => 'primary',
            'address' => 'johnny@example.com'
        ],
        [
            'label' => 'backup',
            'address' => 'johnny.smithy@example.com'
        ]
    ]
]));

$validator = Validator::validate($isotopes);

if ($validator->hasErrors()) {
    echo "Oh No, Failed Validation!";
    $errors = $validator->errors();
    var_dump($errors);
} else {
    echo "Everything Validated!";
    $values = Values::gather($isotopes)->all();
    var_dump($values);
}
