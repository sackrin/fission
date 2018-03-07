<?php

namespace Fission\Schema;

use Fission\Support\Collect;

class Atom {

    public $machine;

    public $scope;

    public $roles;

    public $nuclei;

    public static function create($machine) {

        return new static($machine);
    }

    public function __construct($machine) {
        $this->machine = $machine;
    }

    public function scope($haystack) {
        // Populate the scope values
        $scope = is_string($haystack) ? explode(',', $haystack) : $haystack;
        // If a string was returned then explode by comma
        $this->scope = new Collect($scope);
        // Return for chaining
        return $this;
    }

    public function roles($haystack) {
        // Populate the scope values
        $roles = is_string($haystack) ? explode(',', $haystack) : $haystack;
        // If a string was returned then explode by comma
        $this->roles = new Collect($roles);
        // Return for chaining
        return $this;
    }

    public function nuclei($nuclei) {
        // If a string was returned then explode by comma
        $this->nuclei = $nuclei;
        // Return for chaining
        return $this;
    }

}