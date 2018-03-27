<?php

namespace Fission\Policy;

use Fission\Support\Collect;

trait HasScopeTrait {

    /**
     * @var Collect
     */
    public $scope;

    /**
     * Shortcut Scope Setter
     * @param $scope
     * @return $this
     * @throws \Exception
     */
    public function scope($scope) {
        // Call the scope setter
        return $this->setScope($scope);
    }

    /**
     * Retrieves Scope
     * @return Collect
     */
    public function getScope() {
        // Retrieve the stored scope
        return $this->scope;
    }

    /**
     * Check if collection has scope
     * @param $roles
     * @return bool
     */
    public function inScope($scope) {
        // Return if contains one or more scope values
        return $this->getScope()->containsSome($scope);
    }

    /**
     * Set Scope Collection
     * @param $scope
     * @return $this
     * @throws \Exception
     */
    public function setScope($scope) {
        // If a string was provided
        if (is_string($scope)) {
            // If a string was returned then explode by comma
            $this->scope = new Collect(explode(',', $scope));
        } // If the haystack is a collect instance
        elseif ($scope instanceof Collect) {
            // Directly populate the scope
            $this->scope = $scope;
        } // Otherwise if a straight array is provided
        elseif (is_array($scope)) {
            // If a string was returned then explode by comma
            $this->scope = new Collect($scope);
        }
        // Return for chaining
        return $this;
    }

}