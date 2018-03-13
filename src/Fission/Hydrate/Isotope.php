<?php

namespace Fission\Hydrate;

use Fission\Schema\Nucleus;
use Fission\Schema\NucleusCollection;

class Isotope {

    /**
     * @var mixed
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
     * @throws \Exception
     */
    public static function create(Reactor $reactor, Nucleus $nucelus) {
        // Return a new isotope instance
        return new static($reactor, $nucelus);
    }

    /**
     * Isotope constructor.
     * @param Reactor $reactor
     * @param Nucleus $nucelus
     * @throws \Exception
     */
    public function __construct(Reactor $reactor, Nucleus $nucelus) {
        // Store the reactor instance
        $this->setReactor($reactor);
        // Store the nucleus instance
        $this->setNucleus($nucelus);
        // Initiate the siblings collection
        $this->setSiblings(new NucleusCollection([]));
        // Initiate the isotope collection
        $this->setIsotopes(new IsotopeCollection($this->getReactor(), $nucelus->getNuclei()));
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
     * Get Reactor
     * @param Reactor $reactor
     * @return Isotope
     */
    public function setReactor(Reactor $reactor) {
        // Set the reactor instance
        $this->reactor = $reactor;
        // Return for chaining
        return $this;
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
     * Set Nucleus Instance
     * @param Nucleus $nucleus
     * @return $this
     */
    public function setNucleus(Nucleus $nucleus) {
        // Set the nucleus instance
        $this->nucleus = $nucleus;
        // Return for chaining
        return $this;
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
        $format = $this->nucleus->getFormatters();
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
        $format = $this->nucleus->getFormatters();
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
     * @throws \Exception
     */
    public function sanitize() {
        // Retrieve the nucleus sanitizer collection
        $sanitize = $this->getNucleus()->getSanitizers();
        // Apply the sanitization to the value and repopulate the value
        // We do this because sanitized values is the ideal state of a value
        $this->value = $sanitize->sanitize($this, $this->getValue());
        // Return for chaining
        return $this;
    }

    /**
     * Validate Isotope Value
     * @return array|bool
     * @throws \Exception
     */
    public function validate() {
        // Retrieve the nucleus validate collection
        $validate = $this->getNucleus()->getValidators();
        // Return the result of the validation
        return $validate->validate($this, $this->value);
    }

}