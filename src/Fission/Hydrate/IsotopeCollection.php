<?php

namespace Fission\Hydrate;

use Doctrine\Common\Collections\ArrayCollection;
use Fission\Support\Type;

class IsotopeCollection extends ArrayCollection {

    public $nuclei;

    public $isotopes;

    public function __construct($nuclei, array $elements = []) {
        $this->nuclei = $nuclei;
        parent::__construct($elements);
    }

    public function hydrate($values) {
        // Loop through each of the nuclei
        foreach ($this->nuclei as $nucleus) {
            // Retrieve the nucleus machine code
            // Field names should always match the machine code
            $machine = $nucleus->machine;
            // Retrieve any data passed for this nucleus
            $value = isset($values[$machine]) ? $values[$machine] : null;
            // Create a new isotope instance
            $isotope = Isotope::create($nucleus)
                ->value($value)
                ->sanitize();
            // If this nuclues is a container
            // This means it will have direct property isotopes
            if ($nucleus->type === Type::container()) {
                // Build a new isotope collection
                $collect = (new IsotopeCollection($nucleus->nuclei, []))->hydrate($isotope->value);
                // Generate property isotopes and store
                $isotope->isotopes($collect);
            } // Otherwise if this nucleus is a collection
            // Which means this will have multiple groups of isotopes
            elseif ($nucleus->type === Type::collection() && is_array($isotope->value)) {
                // Loop through each of the value groups
                foreach ($isotope->value as $_value) {
                    // Build a new isotope collection
                    $collect = (new IsotopeCollection($nucleus->nuclei, []))->hydrate($_value);
                    // Add the isotope group to the isotope collection
                    $isotope->isotopes->add($collect);
                }
            }
            // Add the built isotope to the isotope collection
            $this->add($isotope);
        }

        return $this;
    }

}