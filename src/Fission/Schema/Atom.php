<?php

namespace Fission\Schema;

use Fission\Schema\Policy\RolesTrait;
use Fission\Schema\Policy\ScopeTrait;

class Atom {

    use RolesTrait, ScopeTrait;

    public $machine;

    public $nuclei;

    public static function create($machine) {
        return new static($machine);
    }

    public function __construct($machine) {
        $this->machine = $machine;
    }

    public function nuclei($nuclei) {
        // If a string was returned then explode by comma
        $this->nuclei = $nuclei;
        // Return for chaining
        return $this;
    }

}