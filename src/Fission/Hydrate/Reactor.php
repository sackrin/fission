<?php

namespace Fission\Hydrate;

use Fission\Schema\Atom;
use Fission\Support\Collect;
use Fission\Support\Type;

class Reactor {

    protected $atom;

    protected $isotopes;

    protected $values;

    public static function using(Atom $atom) {
        // Return a new reactor instance
        return new static($atom);
    }

    public function __construct(Atom $atom) {
        // Store the atom
        $this->atom = $atom;
        // Initialise with an isotope collection
        $this->isotopes = new IsotopeCollection($atom->nuclei, []);
        // Initialise the values with an array
        $this->values = [];
    }

    public function with($values) {
        // Override any existing values
        $this->values = (array)$values;
        // Build the isotope tree
        $this->isotopes->hydrate($this->values);
        // Return for chaining
        return $this;
    }

    public function merge($values) {
        // Override any existing values
        $this->values = array_replace_recursive($this->values, (array)$values);
        // Build the isotope tree
        $this->isotopes->hydrate($this->values);
        // Return for chaining
        return $this;
    }

    public function isotopes() {
        // Return the built isotopes
        return $this->isotopes;
    }
}