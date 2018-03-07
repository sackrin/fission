<?php

namespace Fission\Schema\Policy;

use Fission\Support\Collect;

class Policy {

    public $roles;

    public $scope;

    public static function roles($value) {

        $instance = new static();
        // Populate the role values
        $roles = is_string($value) ? explode(',', $value) : $value;
        // If a string was returned then explode by comma
        $instance->roles = new Collect($roles);
        // Return for chaining
        return $instance;
    }

    public function getRoles() {
        // Retrieve the roles
        return $this->roles;
    }

    public function inRoles($haystack) {
        // Return if contains one or more roles
        return $this->getRoles()->containsSome($haystack);
    }

    public function scope($value) {
        // Populate the scope values
        $scope = is_string($value) ? explode(',', $value) : $value;
        // If a string was returned then explode by comma
        $this->scope = new Collect($scope);
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