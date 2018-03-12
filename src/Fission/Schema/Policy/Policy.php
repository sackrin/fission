<?php

namespace Fission\Schema\Policy;

use Fission\Hydrate\Isotope;
use Fission\Schema\Policy\Traits\HasRoles;
use Fission\Schema\Policy\Traits\HasScope;

abstract class Policy {

    use HasRoles, HasScope;

    public static function for($roles) {
        // Create a new policy instance
        $instance = new static();
        // Populate the role values
        $instance->roles($roles);
        // Return the built policy instance
        return $instance;
    }

    public abstract function grant(Isotope $isotope, $scope, $roles);

}