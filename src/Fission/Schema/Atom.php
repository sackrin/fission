<?php

namespace Fission\Schema;

use Fission\Schema\Policy\RolesTrait;
use Fission\Schema\Policy\ScopeTrait;

class Atom {

    use RolesTrait, ScopeTrait;

    /**
     * @var string
     */
    public $machine;

    /**
     * @var NucleusCollection
     */
    public $nuclei;

    /**
     * Factory Method
     * @param string $machine
     * @return static
     */
    public static function create(string $machine) {
        // Return a newly built atom instance
        return new static($machine);
    }

    /**
     * Atom constructor.
     * @param string $machine
     */
    public function __construct(string $machine) {
        // Set the machine name
        $this->setMachine($machine);
    }

    /**
     * @return mixed
     */
    public function getMachine() {
        // Return stored machine name
        return $this->machine;
    }

    /**
     * @param mixed $machine
     * @return Atom
     */
    public function setMachine($machine) {
        // Store machine name
        $this->machine = $machine;
        // Return for chaining
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNuclei() {
        // Return nuclei collection
        return $this->nuclei;
    }

    /**
     * @param mixed $nuclei
     * @return Atom
     */
    public function setNuclei(NucleusCollection $nuclei) {
        // Set the nucleus collection
        $this->nuclei = $nuclei;
        // Return for chaining
        return $this;
    }

    /**
     * Shortcut Nuclei Setter
     * @param NucleusCollection $nuclei
     * @return $this
     * @throws \Exception
     */
    public function nuclei($nuclei) {
        // Store passed nucleus collection
        $this->nuclei = new NucleusCollection($nuclei);
        // Return for chaining
        return $this;
    }

}