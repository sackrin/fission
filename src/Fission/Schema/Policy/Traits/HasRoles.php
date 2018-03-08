<?php

namespace Fission\Schema\Policy\Traits;

use Fission\Support\Collect;

trait HasRoles {

    public $roles;

    public function roles($haystack) {
        // If a string was provided
        if (is_string($haystack)) {
            // If a string was returned then explode by comma
            $this->roles = new Collect(explode(',', $haystack));
        } // If the haystack is a collect instance
        elseif ($haystack instanceof Collect) {
            // Directly populate the role
            $this->roles = $haystack;
        } // Otherwise if a straight array is provided
        elseif (is_array($haystack)) {
            // If a string was returned then explode by comma
            $this->roles = new Collect($haystack);
        }
        // Return for chaining
        return $this;
    }

    public function getRoles() {
        // Retrieve the roles
        return $this->roles;
    }

    public function inRoles($haystack) {
        // Return if contains one or more roles
        return $this->getRoles()->containsSome($haystack);
    }

}