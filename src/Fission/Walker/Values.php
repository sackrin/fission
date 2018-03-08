<?php

namespace Fission\Walker;

use Fission\Support\Type;

class Values {

    public $isotopes;

    public static function gather($isotopes) {
        return (new static($isotopes));
    }

    public function __construct($isotopes) {
        $this->isotopes = $isotopes;
    }

    public function get() {
        return $this->walker($this->isotopes);
    }

    public function walker($isotopes) {

        $values = [];
        // Loop through each of the isotopes
        foreach ($isotopes->toArray() as $isotope) {
            // Retrieve the isotope nucleus
            $nucleus = $isotope->nucleus;
            // Retrieve the nucleus machine code
            $machine = $nucleus->machine;
            // If this nuclues is a container
            if ($nucleus->type === Type::container()) {
                //
                $values[$machine] = $this->walker($isotope->isotopes);
            } // Which means this will have multiple groups of isotopes
            elseif ($nucleus->type === Type::collection() && is_array($isotope->value)) {
                // Store group values here
                $group = [];
                // Loop through each of the value groups
                foreach ($isotope->isotopes as $k => $_isotopes) {
                    $group[$machine] = $this->walker($_isotopes);
                }
                // Push the value into the group
                $values[$machine][] = $group;
            } else {
                $values[$machine] = $isotope->value;
            }
        }

        return $values;
    }

}