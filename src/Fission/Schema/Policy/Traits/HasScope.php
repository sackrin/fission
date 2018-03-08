<?php

namespace Fission\Schema\Policy\Traits;

use Fission\Support\Collect;

trait HasScope {

    public $scope;

    public function scope($haystack) {
        // If a string was provided
        if (is_string($haystack)) {
            // If a string was returned then explode by comma
            $this->scope = new Collect(explode(',', $haystack));
        } // If the haystack is a collect instance
        elseif ($haystack instanceof Collect) {
            // Directly populate the scope
            $this->scope = $haystack;
        } // Otherwise if a straight array is provided
        elseif (is_array($haystack)) {
            // If a string was returned then explode by comma
            $this->scope = new Collect($haystack);
        }
        // Return for chaining
        return $this;
    }

    public function getScope() {
        // Retrieve the scope
        return $this->scope;
    }

    public function inScope($haystack) {
        // Return if contains one or more scopes
        return $this->getScope()->containsSome($haystack);
    }

}