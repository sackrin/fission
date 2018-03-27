<?php

namespace Fission\Support;

use Doctrine\Common\Collections\ArrayCollection;

class Collect extends ArrayCollection {

    /**
     * Collect constructor.
     * @param $elements
     * @throws \Exception
     */
    public function __construct($elements) {
        // If a collection was passed, make sure it was the proper collection
        if (is_object($elements)) {
            // Check if the instance passed has a toArray method
            if (!method_exists($elements, 'toArray')) {
                // Throw an exception stating we need the proper collection
                throw new \Exception('Object passed to collection within a toArray method');
            }
            // Extract the array from the passed instance
            $elements = $elements->toArray();
        }
        // Pass through the collection elements
        parent::__construct((array)$elements);
    }

    /**
     * Check If Some Are Present
     * @param $haystack
     * @return bool
     * @throws \Exception
     */
    public function containsSome($haystack) {
        // If the haystack is not a collect then make it one
        // Just helps to keep everything consistent
        if (!$haystack instanceof Collect) {
            // If the haystack was not an array then make one
            // Arrays and Collect instances should be the only things to make it here
            $haystack = new Collect((array) $haystack);
        }
        // If the collection has a wildcard
        if ($this->contains('*')) { return true; }
        // Return if some, or all needles were found
        return count(array_diff($this->toArray(), $haystack->toArray())) < count($this->toArray());
    }

    /**
     * Create New Collect Instance
     * @param $elements
     * @return static
     */
    public function replace($elements) {
        // Retrieve the items to merge or replace
        $elements = $elements instanceof Collect ? $elements->toArray() : (array)$elements;
        // Return a new instance of the collect with the new elements
        return $this->createFrom($elements);
    }

    /**
     * Merge New Elements
     * @param $elements
     * @return $this
     */
    public function merge($elements) {
        // Retrieve the items to merge or replace
        $elements = $elements instanceof Collect ? $elements->toArray() : (array)$elements;
        // Loop through each of the passed new elements
        foreach ($elements as $element) {
            // Add the element to the collection
            $this->add($element);
        }
        // Return the collection
        return $this;
    }

}