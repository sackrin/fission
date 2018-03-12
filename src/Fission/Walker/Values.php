<?php

namespace Fission\Walker;

use Fission\Hydrate\IsotopeCollection;
use Fission\Support\Type;

class Values {

    /**
     * @var IsotopeCollection
     */
    public $isotopes;

    /**
     * @param IsotopeCollection $isotopes
     * @return static
     */
    public static function gather(IsotopeCollection $isotopes) {
        return (new static($isotopes));
    }

    /**
     * Values constructor.
     * @param IsotopeCollection $isotopes
     */
    public function __construct(IsotopeCollection $isotopes) {
        $this->isotopes = $isotopes;
    }

    /**
     * Retrieve the values
     * @return array
     */
    public function all() {
        // Build the values using the tree walker
        return $this->walker($this->isotopes);
    }

    /**
     * Tree Walker
     * @param IsotopeCollection $isotopes
     * @return array
     */
    public function walker(IsotopeCollection $isotopes) {
        // Create a simple array
        $values = [];
        // Loop through each of the isotopes
        foreach ($isotopes->toArray() as $isotope) {
            // Retrieve the isotope nucleus
            $nucleus = $isotope->nucleus;
            // Retrieve the nucleus machine code
            $machine = $nucleus->machine;
            // Retrieve the formatted value
            $value = $isotope->formatted();
            // If this nuclues is a container
            if ($nucleus->type === Type::container()) {
                // Directly populate the values into this value slot
                $values[$machine] = $this->walker($isotope->isotopes);
            } // If this nucleus is a collection of nuclei
            // Which means this will have multiple groups of isotopes
            elseif ($nucleus->type === Type::collection() && is_array($value)) {
                // Create a new simple array
                // Collections will be multiple groups of values
                $group = [];
                // Loop through each of the value groups
                foreach ($isotope->isotopes as $k => $_isotopes) {
                    // Populate the isotope value into the group
                    $group[$machine] = $this->walker($_isotopes);
                }
                // Push the group into the isotope value array
                $values[$machine][] = $group;
            } // Otherwise directly populate the value
            else { $values[$machine] = $isotope->formatted(); }
        }
        // Return the built values
        return $values;
    }

}