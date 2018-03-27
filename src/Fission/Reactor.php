<?php

namespace Fission;

use Fission\Isotope\HasIsotopesTrait;
use Fission\Isotope\IsotopeCollection;
use Fission\Atom;
use Fission\Policy\HasRolesTrait;
use Fission\Policy\HasScopeTrait;
use Fission\Support\Press;

class Reactor {

    use HasScopeTrait, HasRolesTrait, HasIsotopesTrait;

    /**
     * @var Atom
     */
    public $atom;

    /**
     * @var mixed
     */
    public $values;

    /**
     * Factory Method
     * @param Atom $atom
     * @return static
     */
    public static function using(Atom $atom) {
        // Return a new reactor instance
        return new static($atom);
    }

    /**
     * Reactor constructor.
     * @param Atom $atom
     */
    public function __construct(Atom $atom) {
        // Store the atom
        $this->setAtom($atom);
        // Initialise the values with an array
        $this->setValues([]);
        // Initialise with an isotope collection
        $this->setIsotopes(new IsotopeCollection($this, $atom->nuclei));
    }

    /**
     * Set Atom Instance
     * @param Atom $atom
     * @return $this
     */
    public function setAtom(Atom $atom) {
        // Set atom instance
        $this->atom = $atom;
        // Return for chaining
        return $this;
    }

    /**
     * Get Atom
     * @return Atom
     */
    public function getAtom() {
        // Return atom instance
        return $this->atom;
    }

    /**
     * Set Values
     * @param $values
     * @return $this
     */
    public function setValues($values) {
        // Set values
        $this->values = $values;
        // Return for chaining
        return $this;
    }

    /**
     * Get Values
     * @return array
     */
    public function getValues() {
        // Return current values
        return $this->values;
    }

    /**
     * Shortcut Hydration Method
     * @param $values
     * @return $this|IsotopeCollection
     * @throws \Exception
     */
    public function with($values) {
        // Override any existing values
        $this->setValues($values instanceof Press ? $values->all() : (array) $values);
        // Build and hydrate the collection of isotopes
        $isotopes = (new IsotopeCollection($this, $this->getAtom()->getNuclei()))
            ->roles($this->getRoles())
            ->scope($this->getScope())
            ->hydrate($this->getValues());
        // Initialise with an isotope collection
        $this->setIsotopes($isotopes);
        // Return isotope collection
        return $this->getIsotopes();
    }

}