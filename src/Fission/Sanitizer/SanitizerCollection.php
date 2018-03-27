<?php

namespace Fission\Sanitizer;

use Fission\Hydrate\Isotope;
use Fission\Support\Collect;

class SanitizerCollection extends Collect {

    /**
     * Sanitize Value
     * @param Isotope $isotope
     * @param $value
     * @return mixed
     */
    public function sanitize(Isotope $isotope, $values) {
        // Retrieve the elements
        $elements = $this->toArray();
        // Loop through each of the provided
        foreach ($elements as $sanitizer) {
            // Do a interface check
            if (!$sanitizer instanceof SanitizerInterface) {
                // Throw an exception
                throw new \Exception('Sanitizer '.get_class($sanitizer).' does not implement SanitizerInterface');
            }
            // Sanitize against the sanitizer instance
            $values = $sanitizer->sanitize($isotope, $values);
        }
        // If some errors were returned then return an array
        // Otherwise return true to signify successful validation
        return $values;
    }

}