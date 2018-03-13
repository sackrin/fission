<?php

namespace Fission\Schema\Sanitize;

class Sanitize {

    /**
     * @var array
     */
    public $rules;

    /**
     * Factory Method
     * @param $rules
     * @return static
     */
    public static function using($rules) {
        // Generate a new instance and return
        return new static($rules);
    }

    /**
     * Sanitize constructor.
     * @param $rules
     */
    public function __construct($rules) {
        // Populate the provided rules
        $this->rules = $rules;
    }

}