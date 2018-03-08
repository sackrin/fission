<?php

namespace Fission\Walker;

use Fission\Support\Type;

class Validator {

    public $isotopes;

    public $errors;

    public static function validate($isotopes) {
        return (new static($isotopes))->apply();
    }

    public function __construct($isotopes) {
        $this->isotopes = $isotopes;
        $this->errors = [];
    }

    public function apply() {
        $this->walker($this->isotopes, '');
        return $this;
    }

    public function walker($isotopes, $crumb) {
        // Loop through each of the isotopes
        foreach ($isotopes->toArray() as $isotope) {
            // Retrieve the isotope nucleus
            $nucleus = $isotope->nucleus;
            // Retrieve the nucleus machine code
            $machine = $nucleus->machine;
            // Create a new breadcrumb
            $breadcrumb = $crumb ? $crumb.'.'.$machine : $machine;
            // Validate the isotope and retrieve any errors
            $errors = $isotope->validate()->validation;
            // If any errors were found
            if (is_array($errors)) {
                // Add the errors at the breadcrumb location
                $this->errors[$breadcrumb] = $errors;
            }
            // If this nuclues is a container
            if ($nucleus->type === Type::container()) {
                //
                $this->walker($isotope->isotopes, $breadcrumb);
            } // Which means this will have multiple groups of isotopes
            elseif ($nucleus->type === Type::collection() && is_array($isotope->value)) {
                // Loop through each of the value groups
                foreach ($isotope->isotopes as $k => $_isotopes) {
                    $this->walker($_isotopes, $breadcrumb.'.'.$k);
                }
            }
        }

    }

    public function hasErrors() {
        return is_array($this->errors) && count($this->errors) > 0;
    }

    public function errors() {
        return $this->errors;
    }
}