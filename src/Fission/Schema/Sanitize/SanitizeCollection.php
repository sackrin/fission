<?php

namespace Fission\Schema\Sanitize;

use Fission\Support\Collect;

class SanitizeCollection extends Collect {

    public function on($value) {
        return $value;
    }

}