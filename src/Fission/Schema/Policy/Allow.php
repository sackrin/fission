<?php

namespace Fission\Schema\Policy;

class Allow extends Policy {

    public function grant($scope, $roles) {
        // If not in scope then grant
        if (!$this->scope->containsSome($scope)) { return true; }
        // If within the roles then grant
        if ($this->roles->containsSome($roles)) { return true; }
        // Otherwise do not grant the policy check
        return false;
    }

}