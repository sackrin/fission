<?php

namespace Fission\Sanitize;

trait CanSanitizeTrait {

    /**
     * Sanitize Isotope Value
     * @return $this
     * @throws \Exception
     */
    public function sanitize() {
        // Retrieve the nucleus sanitizer collection
        $sanitize = $this->getNucleus()->getSanitizers();
        // Apply the sanitization to the value and repopulate the value
        // We do this because sanitized values is the ideal state of a value
        $this->value = $sanitize->sanitize($this, $this->getValue());
        // Return for chaining
        return $this;
    }

}