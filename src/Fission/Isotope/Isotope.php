<?php

namespace Fission\Isotope;

use Fission\Nucleus\HasNucleusTrait;
use Fission\Reactor;
use Fission\Sanitize\CanSanitizeTrait;
use Fission\Nucleus\Nucleus;
use Fission\Nucleus\NucleiCollection;
use Fission\Validate\CanValidateTrait;

class Isotope {

    use CanSanitizeTrait, CanValidateTrait, HasIsotopesTrait, HasNucleusTrait;

    /**
     * @var mixed
     */
    public $value;

    /**
     * @var Reactor
     */
    public $reactor;

    /**
     * @var NucleiCollection
     */
    public $siblings;

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
        $this->setSiblings(new NucleiCollection([]));
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
     * Set Sibling Nuclei
     * @param NucleiCollection $nuclei
     * @return $this
     */
    public function setSiblings(NucleiCollection $nuclei) {
        // Store the sibling nucleus collection
        $this->siblings = $nuclei;
        // Return for chaining
        return $this;
    }

    /**
     * Get Sibling Nuclei
     * @return NucleiCollection
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

}