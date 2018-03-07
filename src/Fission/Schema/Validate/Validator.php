<?php

namespace Fission\Schema\Validate;

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

        foreach ($isotopes->toArray() as $isotope) {
            $nucleus = $isotope->nucleus;
            $machine = $nucleus->machine;
            $breadcrumb = $crumb ? $crumb.'.'.$machine : $machine;
            $validation = $isotope->validate()->validation;

            if (is_array($validation)) {
                $this->errors[$crumb] = $validation;
            }
            // If this nuclues is a container
            // This means it will have direct property isotopes
            if ($nucleus->type === Type::container()) {
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

    public function errors() {
        return $this->errors;
    }
}