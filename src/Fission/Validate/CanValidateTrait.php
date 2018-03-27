<?php

namespace Fission\Validate;

trait CanValidateTrait {

    /**
     * Validate Isotope Value
     * @return array|bool
     * @throws \Exception
     */
    public function validate() {
        // Retrieve the nucleus validate collection
        $validate = $this->getNucleus()->getValidators();
        // Return the result of the validation
        return $validate->validate($this, $this->value);
    }

}