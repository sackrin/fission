<?php

namespace Fission\Schema\Validate;

use Fission\Hydrate\Isotope;

abstract class AbstractValidator implements ValidatorInterface {

    /**
     * @var mixed
     */
    public $rules;

    /**
     * Factory Method
     * @param $rules
     * @return static
     */
    public abstract static function against($rules);

    /**
     * Validate Value
     * @param Isotope $isotope
     * @param $value
     * @return array|bool
     * @throws \Exception
     */
    public abstract function validate(Isotope $isotope, $value);

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
