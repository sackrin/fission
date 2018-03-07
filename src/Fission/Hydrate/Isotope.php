<?php

namespace Fission\Hydrate;

use Fission\Schema\Nucleus;

class Isotope {

    public $validation;

    public $value;

    public $sanitized;

    public $errors;

    public $nucleus;

    public $isotopes;

    public static function create(Nucleus $nucelus) {
        return new static($nucelus);
    }

    public function __construct(Nucleus $nucelus)
    {
        $this->nucleus = $nucelus;
        $this->isotopes = new IsotopeCollection($nucelus->nuclei, []);
    }

    public function value($value) {
        $this->value = $value;
        return $this;
    }

    public function sanitize() {
        $sanitize = $this->nucleus->sanitize;
        if ($sanitize) {
            $this->sanitized = $sanitize->on($this->value);
        }
        return $this;
    }

    public function validate() {
        $validate = $this->nucleus->validate;
        if ($validate) {
            $this->validation = $validate->validate($this->value);
        }
        return $this;
    }

    public function isotopes(IsotopeCollection $collect) {
        $this->isotopes = $collect;
        return $this;
    }
}