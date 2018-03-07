<?php

namespace Fission\Schema\Sanitize;

class Sanitize {

    public $rules;

    public static function using($rules) {

        return new static($rules);
    }

    public function __construct($rules) {
        $this->rules = $rules;
    }

}