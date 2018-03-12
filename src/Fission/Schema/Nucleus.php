<?php

namespace Fission\Schema;

use Fission\Schema\Format\FormatCollection;
use Fission\Schema\Policy\PolicyCollection;
use Fission\Schema\Sanitize\SanitizeCollection;
use Fission\Schema\Validate\ValidateCollection;
use Fission\Support\Collect;
use Fission\Support\Type;

class Nucleus {

    public $machine;

    public $label;

    public $type;

    public $policies;

    public $sanitize;

    public $format;

    public $validate;

    public $parent;

    public $nuclei;

    public static function create(string $machine) {
        // Create a new nucleus instance
        return new static($machine);
    }

    public function __construct(string $machine) {
        $this->machine = $machine;
        $this->type = Type::string();
        // Initialise the various collections
        $this->nuclei = new NucleusCollection([]);
        $this->policies = new PolicyCollection([]);
        $this->sanitize = new SanitizeCollection([]);
        $this->validate = new ValidateCollection([]);
        $this->format = new FormatCollection([]);
    }

    public function label(string $label) {
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
        $this->policies = new PolicyCollection($policies);
        // Return for chaining
        return $this;
    }

    public function format($format) {
        // Populate the provided label
        $this->format = new FormatCollection($format);
        // Return for chaining
        return $this;
    }

    public function sanitize($sanitize) {
        // Populate the provided label
        $this->sanitize = new SanitizeCollection($sanitize);
        // Return for chaining
        return $this;
    }

    public function validate($validate) {
        // Populate the provided label
        $this->validate = new ValidateCollection($validate);
        // Return for chaining
        return $this;
    }

    public function nuclei($nuclei) {
        // Populate the provided label
        $this->nuclei = new NucleusCollection($nuclei);
        // Return for chaining
        return $this;
    }

}