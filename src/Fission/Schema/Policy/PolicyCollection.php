<?php

namespace Fission\Schema\Policy;

use Fission\Support\Collect;

class PolicyCollection extends Collect {

    public function grant($scope, $roles) {
        // Retrieve the list of policies
        $policies = $this->toArray();
        // If there are no policies then automatically grant
        if (count($policies) == 0) { return true; }
        // Start off NOT granting the policy collection
        $granted = false;
        // Loop through each of the policies
        foreach ($policies as $policy) {
            // Allow the policy to determine if granted
            $policyCheck = $policy->grant($scope, $roles);
            // If the policy check did not grant then continue
            if (!$policyCheck) { continue; }
            // Flag the policy as passed
            $granted = true;
        }
        // Return the result
        return $granted;
    }

}