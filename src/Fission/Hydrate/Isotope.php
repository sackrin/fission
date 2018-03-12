<?php

namespace Fission\Hydrate;

use Fission\Schema\Nucleus;
use Fission\Schema\NucleusCollection;

class Isotope {

    public $validation;

    public $value;

    public $sanitized;

    public $reactor;

    public $siblings;

    public $nucleus;

    public $isotopes;

    public static function create(Reactor $reactor, Nucleus $nucelus) {
        return new static($reactor, $nucelus);
    }

    public function __construct(Reactor $reactor, Nucleus $nucelus)
    {
        $this->nucleus = $nucelus;
        $this->reactor = $reactor;
        $this->isotopes = new IsotopeCollection($this->reactor, $nucelus->nuclei);
    }

    public function siblings(NucleusCollection $nuclei) {
        $this->siblings = $nuclei;
        return $this;
    }

    public function value($value) {
        $format = $this->nucleus->format;
        $this->value = $format->setter($value, $this);
        return $this;
    }

    public function formatted() {
        $format = $this->nucleus->format;
        return $format->getter($this->value, $this);
    }

    public function sanitize() {
        $sanitize = $this->nucleus->sanitize;
        $this->sanitized = $sanitize->sanitize($this, $this->value);
        return $this;
    }

    public function validate() {
        $validate = $this->nucleus->validate;
        $this->validation = $validate->validate($this, $this->value);
        return $this;
    }

    public function isotopes(IsotopeCollection $collect) {
        $this->isotopes = $collect;
        return $this;
    }
}