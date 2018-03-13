<?php

namespace Fission\Schema\Policy;

use Fission\Hydrate\Isotope;
use Fission\Schema\Policy\RolesTrait;
use Fission\Schema\Policy\ScopeTrait;

abstract class Policy {

    use RolesTrait, ScopeTrait;

    /**
     * Factory Method
     * @param $roles
     * @return static
     * @throws \Exception
     */
    public static function for($roles) {
        // Create a new policy instance
        $instance = new static();
        // Populate the role values
        $instance->roles($roles);
        // Return the built policy instance
        return $instance;
    }

    /**
     * Grant Check
     * @param Isotope $isotope
     * @param $scope
     * @param $roles
     * @return mixed
     */
    public abstract function grant(Isotope $isotope, $scope, $roles);

}