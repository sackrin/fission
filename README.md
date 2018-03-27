# Fission PHP Object Schema

A simple to use and extendable php object schema library

<p>
<a href="https://packagist.org/packages/sackrin/fission"><img src="https://poser.pugx.org/sackrin/fission/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/sackrin/fission"><img src="https://poser.pugx.org/sackrin/fission/license.svg" alt="License"></a>
<img src="https://travis-ci.org/sackrin/fission.svg?branch=master" alt="Build Status">
</p>

Add to your project using composer

## Installation

Via composer:

``
composer require sackrin/fission
``

## Example Simple Usage

```php
// Create a new Atom instance
// This will hold the object schema
$atom = Atom::create('person');

// Create some fields to be added to the schema
// These are called nucleus and describe schema properties
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

// Inject the nucleus instances into the atom
// The collective of nucleus is nuclei (just fyi)
$atom->nuclei($nuclei);

// The reactor instance is used to react the atom schema with the nuclei against data
// This is where you will get a hydrated object tree of data
$reactor = Reactor::using($atom)
    ->roles(['user'])
    ->scope(['w','r']);

// Reactors will output a tree of isotopes using the with method
// Isotopes are the hydrated form of a nucleus instance and contain values
// Sanitization, Validation and Policy rules are applied to isotopes
// Press is a util class used to combine and supply data to the reactor instance
// You can just use a standard array if you like
$isotopes = $reactor->with(Press::values([
    'first_name' => ' John '
]));

// Pass the isotope through the validator
$validator = Validator::validate($isotopes);

// Check if the validator has detected any errors
if ($validator->hasErrors()) {
    echo "Oh No, Failed Validation!";
    $errors = $validator->errors();
    var_dump($errors);
} // Otherwise if the validator passed 
else {
    // Using the Values walker you can scrape the data from the isotope tree
    // This will output a simple array tree representing the processed data
    $values = Values::gather($isotopes)->all();
    echo "Everything Validated!";
    $values = Values::gather($isotopes)->all();
    var_dump($values);
}

```

## More Examples

Refer to the [examples](examples/) folder for how to use fission