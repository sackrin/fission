<?php

namespace Fission\Walker;

use Fission\Isotope\Isotope;
use Fission\Isotope\IsotopeCollection;
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
        // Return a new instance of the isotope collection
        return (new static($isotopes));
    }

    /**
     * Values constructor.
     * @param IsotopeCollection $isotopes
     */
    public function __construct(IsotopeCollection $isotopes) {
        // Store the isotope collection
        $this->isotopes = $isotopes;
    }

    /**
     * Retrieve the values
     * @return array
     */
    public function all() {
        // Build the values using the tree walker
        return static::walker($this->isotopes);
    }

    /**
     * Extract Values For Single Isotope
     * @param Isotope $isotope
     * @return array|mixed
     */
    public static function single(Isotope $isotope) {
        // Retrieve the isotope nucleus
        $nucleus = $isotope->getNucleus();
        // Retrieve the formatted value
        $value = $isotope->getValue();
        // If this nuclues is a container
        if ($nucleus->getType() === Type::container()) {
            // Directly return the values
            return static::walker($isotope->getIsotopes());
        } // If this nucleus is a collection of nuclei
        // Which means this will have multiple groups of isotopes
        elseif ($nucleus->getType() === Type::collection() && is_array($value)) {
            // Create a new simple array
            // Collections will be multiple groups of values
            $group = [];
            // Loop through each of the value groups
            foreach ($isotope->getIsotopes() as $k => $_isotopes) {
                // Populate the isotope value into the group
                $group[] = static::walker($_isotopes);
            }
            // Return the group as the isotope value
            return $group;
        } // Otherwise directly return the value
        else { return $isotope->getValue(); }
    }

    /**
     * Tree Walker
     * @param IsotopeCollection $isotopes
     * @return array
     */
    public static function walker(IsotopeCollection $isotopes) {
        // Create a simple array
        $values = [];
        // Loop through each of the isotopes
        foreach ($isotopes->toArray() as $isotope) {
            // Retrieve the isotope nucleus
            $nucleus = $isotope->getNucleus();
            // Retrieve the nucleus machine code
            $machine = $nucleus->getMachine();
            // Retrieve the formatted value
            $values[$machine] = static::single($isotope);
        }
        // Return the built values
        return $values;
    }

}