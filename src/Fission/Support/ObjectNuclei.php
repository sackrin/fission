<?php

namespace Fission\Support;

use Fission\Nucleus\NucleiCollection;

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
        $this->nuclei = new NucleiCollection($nuclei);
        // Return for chaining
        return $this;
    }

}