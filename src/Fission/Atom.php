<?php

namespace Fission;

use Fission\Nucleus\HasNucleiTrait;
use Fission\Nucleus\NucleiCollection;
use Fission\Policy\HasRolesTrait;
use Fission\Policy\HasScopeTrait;

class Atom {

    use HasRolesTrait, HasScopeTrait, HasNucleiTrait;

    /**
     * @var string
     */
    public $machine;

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

}