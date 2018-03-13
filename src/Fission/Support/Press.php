<?php

namespace Fission\Support;

class Press {

    /**
     * @var array
     */
    public $values;

    /**
     * Press constructor.
     * @param $values
     */
    public function __construct($values) {
        // Override any existing values
        $this->values = (array)$values;
    }

    /**
     * Factory Method
     * @param $values
     * @return static
     */
    public static function values($values) {
        // Return a new press instance
        return new static($values);
    }

    /**
     * Merge Additional Values
     * @param $values
     * @return $this
     */
    public function and($values) {
        // Override any existing values
        $this->values = array_replace_recursive($this->values, (array)$values);
        // Return for chaining
        return $this;
    }

    /**
     * Retrieve All Values
     * @return array
     */
    public function all() {
        // Return all current values
        return $this->values;
    }
}