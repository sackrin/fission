<?php

namespace Fission\Sanitize;

use Fission\Isotope\Isotope;

interface SanitizerInterface {

    /**
     * Factory Method
     * @param $rules
     * @return static
     */
    public static function using($rules);

    /**
     * Sanitize Value
     * @param Isotope $isotope
     * @param $value
     * @return array|bool
     * @throws \Exception
     */
    public function sanitize(Isotope $isotope, $value);

}
