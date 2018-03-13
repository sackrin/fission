<?php

namespace Fission\Schema\Sanitize;

use Fission\Hydrate\Isotope;
use Fission\Support\Collect;

class SanitizeCollection extends Collect {

    /**
     * Sanitize Value
     * @param Isotope $isotope
     * @param $value
     * @return mixed
     */
    public function sanitize(Isotope $isotope, $value) {
        // Return sanitized value
        return $value;
    }

}