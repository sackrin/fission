<?php

namespace Fission\Schema\Sanitize;

use Fission\Hydrate\Isotope;

abstract class AbstractSanitizer implements SanitizerInterface {

    /**
     * Factory Method
     * @param $rules
     * @return static
     */
    public abstract static function using($rules);

    /**
     * Sanitize Value
     * @param Isotope $isotope
     * @param $value
     * @return array|bool
     * @throws \Exception
     */
    public abstract function sanitize(Isotope $isotope, $value);

    /**
     * Rules Getter
     * @param $rules
     * @return mixed
     */
    public function getRules($rules) {
        // Return currently set rules
        return $this->rules;
    }

    /**
     * Rules Setter
     * @param $rules
     * @return $this
     */
    public function setRules($rules) {
        // Set provided rules
        $this->rules = $rules;
        // Return for chaining
        return $this;
    }
}
