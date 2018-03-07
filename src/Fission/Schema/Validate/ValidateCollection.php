<?php

namespace Fission\Schema\Validate;

use Fission\Support\Collect;

class ValidateCollection extends Collect {

    public function validate($values) {

        $errors = [];

        foreach ($this->toArray() as $validator) {
            $validate = $validator->apply($values);
            if (!is_array($validate)) { continue; }
            $errors = array_merge($errors, $validate);
        }

        return count($errors) > 0 ? $errors : true;
    }

}