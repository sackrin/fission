<?php

namespace Fission\Support;

use Doctrine\Common\Collections\ArrayCollection;

class Collect extends ArrayCollection {

    public function containsSome($haystack) {
        // If the collection has a wildcard
        if (in_array('*', $haystack)) {
            // Return found
            return true;
        }
        // Retrieve the array elements
        $elements = $this->toArray();
        // Return if some, or all needles were found
        return count(array_diff($elements, $haystack)) < count($elements);
    }

}