<?php

namespace Fission\Schema\Sanitize;

use Fission\Hydrate\Isotope;
use GUMP;

class GUMPSanitizer extends AbstractSanitizer  {

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

    /**
     * Sanitize Value
     * @param Isotope $isotope
     * @param $value
     * @return array|bool
     * @throws \Exception
     */
    public function sanitize(Isotope $isotope, $value) {
        // Create a new gump instance
        $gump = new GUMP();
        // Generate a temporary file field name
        $tmp = uniqid();
        // Filter the values
        $filtered = $gump->filter([$tmp => (string)$value], [$tmp => $this->rules]);
        // Setup the filter rules
        return $filtered[$tmp];
    }


}