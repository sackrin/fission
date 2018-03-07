<?php

namespace Fission\Schema;

use Fission\Schema\Policy\PolicyCollection;
use Fission\Schema\Sanitize\SanitizeCollection;
use Fission\Schema\Validate\ValidateCollection;

class Nucleus {

    public $machine;

    public $label;

    public $type;

    public $policies;

    public $sanitize;

    public $validate;

    public $parent;

    public $nuclei;

    public static function create($machine) {
        // Create a new nucleus instance
        return new static($machine);
    }

    public function __construct($machine) {
        $this->machine = $machine;
        $this->nuclei = new NucleusCollection([]);
        $this->policies = new PolicyCollection([]);
    }

    public function label($label) {
        // Populate the provided label
        $this->label = $label;
        // Return for chaining
        return $this;
    }

    public function type($type) {
        // Populate the provided label
        $this->type = $type;
        // Return for chaining
        return $this;
    }

    public function policies($policies) {
        // Populate the provided label
        $this->policies = new PolicyCollection((array)$policies);
        // Return for chaining
        return $this;
    }

    public function nuclei($nuclei) {
        // Populate the provided label
        $this->nuclei = new NucleusCollection((array)$nuclei);
        // Return for chaining
        return $this;
    }

    public function sanitize($sanitize) {
        // Populate the provided label
        $this->sanitize = new SanitizeCollection((array)$sanitize);
        // Return for chaining
        return $this;
    }

    public function validate($validate) {
        // Populate the provided label
        $this->validate = new ValidateCollection((array)$validate);
        // Return for chaining
        return $this;
    }

}