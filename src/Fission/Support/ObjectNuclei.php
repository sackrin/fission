<?php

namespace Fission\Support;

use Fission\Schema\NucleusCollection;

class ObjectNuclei {

    public $nuclei;

    /**
     * @return mixed
     */
    public function getNuclei() {
        // Return the stored nuclei
        return $this->nuclei;
    }

    /**
     * @param mixed $nuclei
     * @return ObjectNuclei
     * @throws \Exception
     */
    public function setNuclei($nuclei) {
        // Set the passed nuclei as a nucleus collection
        $this->nuclei = new NucleusCollection($nuclei);
        // Return for chaining
        return $this;
    }

}