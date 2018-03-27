<?php

namespace Fission\Validate;

use Fission\Isotope\Isotope;
use Fission\Support\Collect;

class ValidatorCollection extends Collect {

    /**
     * Validate Against Value
     * @param Isotope $isotope
     * @param $values
     * @return array|bool
     * @throws \Exception
     */
    public function validate(Isotope $isotope, $values) {
        // Simple array to store errors
        $errors = [];
        // Retrieve the elements
        $elements = $this->toArray();
        // Loop through each of the provided
        foreach ($elements as $validator) {
            // Do a interface check
            if (!$validator instanceof ValidatorInterface) {
                // Throw an exception
                throw new \Exception('Validator '.get_class($validator).' does not implement ValidateInterface');
            }
            // Validate against the validator instance
            $result = $validator->validate($isotope, $values);
            // If errors were returned
            if (!is_array($result)) { continue; }
            // Merge with the current list of errors
            $errors = array_merge($errors, $result);
        }
        // If some errors were returned then return an array
        // Otherwise return true to signify successful validation
        return count($errors) > 0 ? $errors : true;
    }

}
