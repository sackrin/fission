<?php

namespace Fission\Hydrate;

use Fission\Schema\Nucleus;
use Fission\Schema\NucleusCollection;

class Isotope {

    /**
     * @var
     */
    public $value;

    /**
     * @var Reactor
     */
    public $reactor;

    /**
     * @var NucleusCollection
     */
    public $siblings;

    /**
     * @var Nucleus
     */
    public $nucleus;

    /**
     * @var IsotopeCollection
     */
    public $isotopes;

    /**
     * Isotope Factory Method
     * @param Reactor $reactor
     * @param Nucleus $nucelus
     * @return static
     */
    public static function create(Reactor $reactor, Nucleus $nucelus) {
        // Return a new isotope instance
        return new static($reactor, $nucelus);
    }

    /**
     * Isotope constructor.
     * @param Reactor $reactor
     * @param Nucleus $nucelus
     */
    public function __construct(Reactor $reactor, Nucleus $nucelus) {
        // Store the reactor instance
        $this->reactor = $reactor;
        // Store the nucleus instance
        $this->nucleus = $nucelus;
        // Initiate the siblings collection
        $this->siblings = new NucleusCollection([]);
        // Initiate the isotope collection
        $this->isotopes = new IsotopeCollection($this->reactor, $nucelus->nuclei);
    }

    /**
     * Get Reactor
     * @return Reactor
     */
    public function getReactor() {
        // Return the stored reactor instance
        return $this->reactor;
    }

    /**
     * Get Nucleus Instance
     * @return Nucleus
     */
    public function getNucleus() {
        // Return the stored nucleus instance
        return $this->nucleus;
    }

    /**
     * Set Sibling Nuclei
     * @param NucleusCollection $nuclei
     * @return $this
     */
    public function setSiblings(NucleusCollection $nuclei) {
        // Store the sibling nucleus collection
        $this->siblings = $nuclei;
        // Return for chaining
        return $this;
    }

    /**
     * Get Sibling Nuclei
     * @return NucleusCollection
     */
    public function getSiblings() {
        // Return the nucleus collection
        return $this->siblings;
    }

    /**
     * Set Isotope Value
     * @param $value
     * @return $this
     */
    public function setValue($value) {
        // Retrieve the nucleus formatter
        $format = $this->nucleus->format;
        // Pass the value through any format setters
        $this->value = $format->setter($this, $value);
        // Return for chaining
        return $this;
    }

    /**
     * Get Isotope Value
     * @return mixed
     */
    public function getValue() {
        // Retrieve the nucleus formatter
        $format = $this->nucleus->format;
        // Return the formatted value
        return $format->getter($this);
    }

    /**
     * Inject Isotope collection
     * @param IsotopeCollection $collect
     * @return $this
     */
    public function setIsotopes(IsotopeCollection $collect) {
        // Store the isotope collection
        $this->isotopes = $collect;
        // Return for chaining
        return $this;
    }

    /**
     * Return The Isotope Collection
     * @return IsotopeCollection
     */
    public function getIsotopes() {
        // Return the isotope collection
        return $this->isotopes;
    }

    /**
     * Sanitize Isotope Value
     * @return $this
     */
    public function sanitize() {
        // Retrieve the nucleus sanitizer collection
        $sanitize = $this->nucleus->sanitize;
        // Apply the sanitization to the value and repopulate the value
        // We do this because sanitized values is the ideal state of a value
        $this->value = $sanitize->sanitize($this, $this->value);
        // Return for chaining
        return $this;
    }

    /**
     * Validate Isotope Value
     * @return $this
     */
    public function validate() {
        // Retrieve the nucleus validate collection
        $validate = $this->nucleus->validate;
        // Return the result of the validation
        return $validate->validate($this, $this->value);
    }

}