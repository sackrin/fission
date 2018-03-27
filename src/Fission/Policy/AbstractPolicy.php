<?php

namespace Fission\Policy;

use Fission\Isotope\Isotope;
use Fission\Policy\HasRolesTrait;
use Fission\Policy\HasScopeTrait;

abstract class AbstractPolicy {

    use HasRolesTrait, HasScopeTrait;

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