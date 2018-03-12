<?php

namespace Fission\Schema\Sanitize;

use Fission\Hydrate\Isotope;
use Fission\Support\Collect;

class SanitizeCollection extends Collect {

    public function sanitize(Isotope $isotope, $value) {
        return $value;
    }

}