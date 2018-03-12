<?php

namespace Fission\Schema\Policy;

use Fission\Hydrate\Isotope;

class Deny extends Policy {

    public function grant(Isotope $isotope, $scope, $roles) {
        // If not in scope then grant
        if (!$this->scope->containsSome($scope)) { return true; }
        // If not within the roles then grant
        if (!$this->roles->containsSome($roles, true)) { return true; }
        // Otherwise do not grant the policy check
        return false;
    }

}