<?php

namespace Fission\Nucleus;

trait HasNucleusTrait {

    /**
     * @var Nucleus
     */
    public $nucleus;

    /**
     * Get Nucleus Instance
     * @return Nucleus
     */
    public function getNucleus() {
        // Return the stored nucleus instance
        return $this->nucleus;
    }

    /**
     * Set Nucleus Instance
     * @param Nucleus $nucleus
     * @return $this
     */
    public function setNucleus(Nucleus $nucleus) {
        // Set the nucleus instance
        $this->nucleus = $nucleus;
        // Return for chaining
        return $this;
    }

}