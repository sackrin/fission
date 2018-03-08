<?php

namespace Fission\Support;

use Doctrine\Common\Collections\ArrayCollection;

class Collect extends ArrayCollection {

    public function containsSome($haystack, $debug=false) {
        // If the haystack is not a collect then make it one
        // Just helps to keep everything consistent
        if (!$haystack instanceof Collect) {
            // If the haystack was not an array then make one
            // Arrays and collect instances should be the only things to make it here
            $haystack = new Collect((array) $haystack);
        }
        // If the collection has a wildcard
        if ($this->contains('*')) {
            // Return found
            return true;
        }
        // Return if some, or all needles were found
        return count(array_diff($this->toArray(), $haystack->toArray())) < count($this->toArray());
    }

}