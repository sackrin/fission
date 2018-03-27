<?php

namespace Fission\Policy;

use Fission\Isotope\Isotope;
use Fission\Support\Collect;

class PolicyCollection extends Collect {

    /**
     * @param Isotope $isotope
     * @param $scope
     * @param $roles
     * @return bool
     */
    public function grant(Isotope $isotope, $scope, $roles) {
        // Retrieve the list of policies
        $policies = $this->toArray();
        // If there are no policies then automatically grant
        if (count($policies) == 0) { return true; }
        // Start off NOT granting the policy collection
        $granted = false;
        // Loop through each of the policies
        foreach ($policies as $policy) {
            // Allow the policy to determine if granted
            $policyCheck = $policy->grant($isotope, $scope, $roles);
            // If the policy check did not grant then continue
            if (!$policyCheck) { continue; }
            // Flag the policy as passed
            $granted = true;
        }
        // Return the result
        return $granted;
    }

}