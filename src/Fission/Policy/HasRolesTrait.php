<?php

namespace Fission\Policy;

use Fission\Support\Collect;

trait HasRolesTrait {

    /**
     * @var Collect
     */
    public $roles;

    /**
     * Shortcut Setter
     * @param $roles
     * @return $this
     * @throws \Exception
     */
    public function roles($roles) {
        // Call the role setter
        return $this->setRoles($roles);
    }

    /**
     * Set role collection
     * @param $roles
     * @return $this
     * @throws \Exception
     */
    public function setRoles($roles) {
        // If a string was provided
        if (is_string($roles)) {
            // If a string was returned then explode by comma
            $this->roles = new Collect(explode(',', $roles));
        } // If the haystack is a collect instance
        elseif ($roles instanceof Collect) {
            // Directly populate the role
            $this->roles = $roles;
        } // Otherwise if a straight array is provided
        elseif (is_array($roles)) {
            // If a string was returned then explode by comma
            $this->roles = new Collect($roles);
        }
        // Return for chaining
        return $this;
    }

    /**
     * Retrieve Roles
     * @return Collect
     */
    public function getRoles() {
        // Retrieve the stored roles
        return $this->roles;
    }

    /**
     * Check if collection has roles
     * @param $roles
     * @return bool
     */
    public function inRoles($roles) {
        // Return if contains one or more roles
        return $this->getRoles()->containsSome($roles);
    }

}