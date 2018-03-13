<?php

namespace Fission\Schema\Validate;

use Fission\Hydrate\Isotope;

interface ValidateInterface {

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
