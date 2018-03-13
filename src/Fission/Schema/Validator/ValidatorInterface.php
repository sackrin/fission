<?php

namespace Fission\Schema\Validator;

use Fission\Hydrate\Isotope;

interface ValidatorInterface {

    /**
     * Factory Method
     * @param $rules
     * @return static
     */
    public static function against($rules);

    /**
     * Validate Value
     * @param Isotope $isotope
     * @param $value
     * @return array|bool
     * @throws \Exception
     */
    public function validate(Isotope $isotope, $value);

}
