<?php

namespace Fission\Schema\Policy;

use Fission\Hydrate\Isotope;

class Deny extends Policy {

    /**
     * Grant Access Using Scope & Roles
     * @param Isotope $isotope
     * @param $scope
     * @param $roles
     * @return bool
     * @throws \Exception
     */
    public function grant(Isotope $isotope, $scope, $roles) {
        // Always, if this policy is out of scope then grant policy check
        if (!$this->scope->containsSome($scope)) { return true; }
        // If none of the provided roles were found then grant policy check
        if (!$this->roles->containsSome($roles)) { return true; }
        // Otherwise do not grant the policy check
        return false;
    }

}