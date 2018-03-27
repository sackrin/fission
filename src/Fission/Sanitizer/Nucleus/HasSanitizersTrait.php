<?php

namespace Fission\Sanitizer\Nucleus;

use Fission\Sanitizer\SanitizerCollection;

trait HasSanitizersTrait {

    /**
     * @var SanitizerCollection
     */
    public $sanitizers;

    /**
     * @return SanitizerCollection
     */
    public function getSanitizers() {
        // Return the sanitizersr collection
        return $this->sanitizers;
    }

    /**
     * @param SanitizerCollection $sanitizers
     * @return $this
     */
    public function setSanitizers(SanitizerCollection $sanitizers) {
        // Set the sanitizer collection
        $this->sanitizers = $sanitizers;
        // Return for chaining
        return $this;
    }

    /**
     * @param $sanitizers
     * @return $this
     * @throws \Exception
     */
    public function sanitizers($sanitizers) {
        // Populate and return for chaining
        return $this->setSanitizers(new SanitizerCollection($sanitizers));
    }


}