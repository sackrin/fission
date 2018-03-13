<?php

namespace Fission\Hydrate;

use Fission\Schema\Atom;
use Fission\Schema\Policy\RolesTrait;
use Fission\Schema\Policy\ScopeTrait;
use Fission\Support\Press;

class Reactor {

    use ScopeTrait, RolesTrait;

    /**
     * @var Atom
     */
    public $atom;

    /**
     * @var IsotopeCollection
     */
    public $isotopes;

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
     * Set Isotope Collection
     * @param IsotopeCollection $isotopes
     * @return $this
     */
    public function setIsotopes(IsotopeCollection $isotopes) {
        // Set isotope collection
        $this->isotopes = $isotopes;
        // Return for chaining
        return $this;
    }

    /**
     * Get Isotope Collection
     * @return IsotopeCollection
     */
    public function getIsotopes() {
        // Return isotope collection
        return $this->isotopes;
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
        $isotopes = (new IsotopeCollection($this, $this->atom->nuclei))
            ->roles($this->roles)
            ->scope($this->scope)
            ->hydrate($this->values);
        // Initialise with an isotope collection
        $this->setIsotopes($isotopes);
        // Return isotope collection
        return $this->getIsotopes();
    }

}