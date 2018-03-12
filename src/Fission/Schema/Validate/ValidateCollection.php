<?php

namespace Fission\Schema\Validate;

use Fission\Hydrate\Isotope;
use Fission\Support\Collect;

class ValidateCollection extends Collect {

    public function validate(Isotope $isotope, $values) {

        $errors = [];

        foreach ($this->toArray() as $validator) {
            $validate = $validator->apply($isotope, $values);
            if (!is_array($validate)) { continue; }
            $errors = array_merge($errors, $validate);
        }

        return count($errors) > 0 ? $errors : true;
    }

}