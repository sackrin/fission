<?php

namespace Fission\Nucleus;

trait HasNucleiTrait {

    /**
     * @var NucleiCollection
     */
    public $nuclei;

    /**
     * @return NucleiCollection
     */
    public function getNuclei() {
        // Return the nuclei collection
        return $this->nuclei;
    }

    /**
     * @param NucleiCollection $nuclei
     * @return Nucleus
     */
    public function setNuclei(NucleiCollection $nuclei) {
        // Set the nuclei collection
        $this->nuclei = $nuclei;
        // Return for chaining
        return $this;
    }

    /**
     * @param $nuclei
     * @return Nucleus
     * @throws \Exception
     */
    public function nuclei($nuclei) {
        // If a potential classname has been passed
        if (is_string($nuclei) && class_exists($nuclei)) {
            // Populate the nuclei with the result of the get nuclei method
            $this->nuclei = new NucleiCollection((new $nuclei())->getNuclei());
        } // Otherwise if an object was passed
        elseif (is_object($nuclei) && method_exists($nuclei, 'getNuclei')) {
            // Populate the nuclei with the result of the get nuclei method
            $this->nuclei = new NucleiCollection($nuclei()->getNuclei());
        } // Otherwise pass through to the nucleus collection
        else { $this->nuclei = new NucleiCollection($nuclei); }
        // Return for chaining
        return $this;
    }

}