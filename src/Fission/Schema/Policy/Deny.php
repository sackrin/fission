<?php

namespace Fission\Schema\Policy;

class Deny extends Policy {

    public function grant($scope, $roles) {
        // If not in scope then grant
        if (!$this->scope->containsSome($scope)) { return true; }
        // If not within the roles then grant
        if (!$this->roles->containsSome($roles, true)) { return true; }
        // Otherwise do not grant the policy check
        return false;
    }

}