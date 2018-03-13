<?php

namespace Fission\Hydrate;

use Fission\Schema\Atom;
use Fission\Schema\Policy\RolesTrait;
use Fission\Schema\Policy\ScopeTrait;
use Fission\Support\Press;

class Reactor {

    use ScopeTrait, RolesTrait;

    public $atom;

    public $isotopes;

    public $values;

    public static function using(Atom $atom) {
        // Return a new reactor instance
        return new static($atom);
    }

    public function __construct(Atom $atom) {
        // Store the atom
        $this->atom = $atom;
        // Initialise with an isotope collection
        $this->isotopes = new IsotopeCollection($this, $atom->nuclei);
        // Initialise the values with an array
        $this->values = [];
    }

    public function with($values) {
        // Override any existing values
        $this->values = $values instanceof Press ? $values->all() : (array) $values;
        // Initialise with an isotope collection
        $this->isotopes = (new IsotopeCollection($this, $this->atom->nuclei))
            ->roles($this->roles)
            ->scope($this->scope)
            ->hydrate($this->values);
        // Return for chaining
        return $this->isotopes;
    }

}