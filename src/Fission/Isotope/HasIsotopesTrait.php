<?php

namespace Fission\Isotope;

trait HasIsotopesTrait {

    /**
     * @var IsotopeCollection
     */
    public $isotopes;

    /**
     * Set Isotope Collection
     * @param IsotopeCollection $isotopes
     * @return $this
     */
    public function setIsotopes(IsotopeCollection $isotopes) {
        // Set isotope collection
        $this->isotopes = $isotopes;
        // Return for chaining
        return $this;
    }

    /**
     * Get Isotope Collection
     * @return IsotopeCollection
     */
    public function getIsotopes() {
        // Return isotope collection
        return $this->isotopes;
    }

}
