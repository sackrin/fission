<?php

namespace Fission\Validate;

trait HasValidatorsTrait {

    /**
     * @var ValidatorCollection
     */
    public $validators;

    /**
     * @param ValidatorCollection $validators
     * @return $this
     */
    public function setValidators(ValidatorCollection $validators) {
        // Set the validator collection
        $this->validators = $validators;
        // Return for chaining
        return $this;
    }

    /**
     * @return ValidatorCollection
     */
    public function getValidators() {
        // Return the validator collection
        return $this->validators instanceof ValidatorCollection ? $this->validators : new ValidatorCollection([]);
    }

    /**
     * @param $validators
     * @return $this
     * @throws \Exception
     */
    public function validators($validators) {
        // Populate and return for chaining
        return $this->setValidators(new ValidatorCollection($validators));
    }

}