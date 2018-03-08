<?php

namespace Fission\Support\Util;

class Press {

    public $values;

    public function __construct($values) {
        // Override any existing values
        $this->values = (array)$values;
    }

    public static function values($values) {
        // Return a new instance
        return new static($values);
    }

    public function and($values) {
        // Override any existing values
        $this->values = array_replace_recursive($this->values, (array)$values);
        // Return for chaining
        return $this;
    }

    public function all() {
        return $this->values;
    }
}