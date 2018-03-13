<?php

namespace Fission\Walker;

use Fission\Hydrate\IsotopeCollection;
use Fission\Support\Type;

class Validator {

    /**
     * @var IsotopeCollection
     */
    public $isotopes;

    /**
     * @var array
     */
    public $errors;

    /**
     * Factory Method
     * @param IsotopeCollection $isotopes
     * @return mixed
     */
    public static function validate(IsotopeCollection $isotopes) {
        // Return a new validator instance
        return (new static($isotopes))->apply();
    }

    /**
     * Validator constructor.
     * @param IsotopeCollection $isotopes
     */
    public function __construct(IsotopeCollection $isotopes) {
        // Store the isotope collection
        $this->isotopes = $isotopes;
        // Initiate the errors simple array
        $this->errors = [];
    }

    /**
     * Retreieve Isotope Collection
     * @return IsotopeCollection
     */
    public function getIsotopes() {
        // Return the collection of isotopes
        return $this->isotopes;
    }

    /**
     * Check If Errors Were Detected
     * @return bool
     */
    public function hasErrors() {
        // Return true if any errors were found
        return is_array($this->errors) && count($this->errors) > 0;
    }

    /**
     * Return Found Errors
     * @return array
     */
    public function errors() {
        // Return stored errors
        return $this->errors;
    }

    /**
     * Apply Validation Checks
     * @return $this
     */
    public function apply() {
        // Begin the validation walker
        $this->walker($this->isotopes, '');
        // Return for chaining
        return $this;
    }

    /**
     * Validation Walker
     * @param IsotopeCollection $isotopes
     * @param string $crumb
     * @return $this
     */
    public function walker(IsotopeCollection $isotopes, string $crumb) {
        // Retrieve the isotope collection
        $collection = $isotopes->toArray();
        // Loop through each of the isotopes
        foreach ($collection as $isotope) {
            // Retrieve the isotope nucleus
            $nucleus = $isotope->getNucleus();
            // Retrieve the nucleus machine code
            $machine = $nucleus->getMachine();
            // Create the breadcrumb for this isotope
            $breadcrumb = $crumb ? $crumb.'.'.$machine : $machine;
            // Validate the isotope and retrieve any errors
            $errors = $isotope->validate();
            // If validation errors were returned
            if (is_array($errors)) {
                // Add the errors at the breadcrumb location
                $this->errors[$breadcrumb] = $errors;
            }
            // If this nucleus is a container
            if ($nucleus->type === Type::container()) {
                // Run the walker on the isotope isotopes collection
                $this->walker($isotope->isotopes, $breadcrumb);
            } // Otherwise if this nucleus is a collection
            // Which means this will have multiple groups of isotopes
            elseif ($nucleus->type === Type::collection() && is_array($isotope->value)) {
                // Loop through each of the value groups
                foreach ($isotope->isotopes as $k => $_isotopes) {
                    // Run the walker on the isotope isotopes collection
                    $this->walker($_isotopes, $breadcrumb.'.'.$k);
                }
            }
        }
        // Return for chaining
        return $this;
    }

}