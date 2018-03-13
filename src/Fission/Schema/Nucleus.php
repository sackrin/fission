<?php

namespace Fission\Schema;

use Fission\Schema\Formatter\FormatterCollection;
use Fission\Schema\Policy\PolicyCollection;
use Fission\Schema\Sanitizer\SanitizerCollection;
use Fission\Schema\Validator\ValidatorCollection;
use Fission\Support\Type;

class Nucleus {

    /**
     * @var string
     */
    public $machine;

    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $type;

    /**
     * @var PolicyCollection
     */
    public $policies;

    /**
     * @var SanitizerCollection
     */
    public $sanitizers;

    /**
     * @var FormatterCollection
     */
    public $formatters;

    /**
     * @var ValidatorCollection
     */
    public $validators;

    /**
     * @var Nucleus
     */
    public $parent;

    /**
     * @var NucleusCollection
     */
    public $nuclei;

    /**
     * Factory Method
     * @param string $machine
     * @return static
     * @throws \Exception
     */
    public static function create(string $machine) {
        // Create a new nucleus instance
        return new static($machine);
    }

    /**
     * Nucleus constructor.
     * @param string $machine
     * @throws \Exception
     */
    public function __construct(string $machine) {
        // Set the machine name
        $this->setMachine($machine);
        // Set the nucleus type
        $this->setType(Type::string());
        // Initialise the various collections
        $this->setNuclei(new NucleusCollection([]));
        $this->setPolicies(new PolicyCollection([]));
        $this->setSanitizers(new SanitizerCollection([]));
        $this->setValidators(new ValidatorCollection([]));
        $this->setFormatters(new FormatterCollection([]));
    }

    /**
     * @return string
     */
    public function getMachine() {
        // Return the machine
        return $this->machine;
    }

    /**
     * @param string $machine
     * @return Nucleus
     */
    public function setMachine(string $machine) {
        // Set the machine value
        $this->machine = $machine;
        // Return for chaining
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabel() {
        // Return the label value
        return $this->label;
    }

    /**
     * @param mixed $label
     * @return Nucleus
     */
    public function setLabel($label) {
        // Set the label
        $this->label = $label;
        // Return for chaining
        return $this;
    }

    /**
     * @return string
     */
    public function getType() {
        // Return the type
        return $this->type;
    }

    /**
     * @param string $type
     * @return Nucleus
     */
    public function setType(string $type) {
        // Set the type
        $this->type = $type;
        // Return for chaining
        return $this;
    }

    /**
     * @return PolicyCollection
     */
    public function getPolicies() {
        // Return the policy collection
        return $this->policies;
    }

    /**
     * @param PolicyCollection $policies
     * @return Nucleus
     */
    public function setPolicies(PolicyCollection $policies) {
        // Set the policies collection
        $this->policies = $policies;
        // Return for chaining
        return $this;
    }

    /**
     * @return SanitizerCollection
     */
    public function getSanitizers() {
        // Return the sanitizersr collection
        return $this->sanitizers;
    }

    /**
     * @param SanitizerCollection $sanitizers
     * @return Nucleus
     */
    public function setSanitizers(SanitizerCollection $sanitizers) {
        // Set the santizer collection
        $this->sanitizers = $sanitizers;
        // Return for chaining
        return $this;
    }

    /**
     * @return FormatterCollection
     */
    public function getFormatters() {
        // Return the formatterster collection
        return $this->formatters;
    }

    /**
     * @param FormatterCollection $formatters
     * @return Nucleus
     */
    public function setFormatters(FormatterCollection $formatters) {
        // Set the formatterster collection
        $this->formatters = $formatters;
        // Return for chaining
        return $this;
    }

    /**
     * @return ValidatorCollection
     */
    public function getValidators() {
        // Return the validator collection
        return $this->validators;
    }

    /**
     * @param ValidatorCollection $validators
     * @return Nucleus
     */
    public function setValidators(ValidatorCollection $validators) {
        // Set the validator collection
        $this->validators = $validators;
        // Return for chaining
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParent() {
        // Return the stored parent
        return $this->parent;
    }

    /**
     * @param mixed $parent
     * @return Nucleus
     */
    public function setParent(Nucleus $parent) {
        // Set the parent nucleus
        $this->parent = $parent;
        // Return for chaining
        return $this;
    }

    /**
     * @return NucleusCollection
     */
    public function getNuclei() {
        // Return the nuclei collection
        return $this->nuclei;
    }

    /**
     * @param NucleusCollection $nuclei
     * @return Nucleus
     */
    public function setNuclei(NucleusCollection $nuclei) {
        // Set the nuclei collection
        $this->nuclei = $nuclei;
        // Return for chaining
        return $this;
    }

    /**
     * @param string $label
     * @return Nucleus
     */
    public function label(string $label) {
        // Populate and return for chaining
        return $this->setLabel($label);
    }

    /**
     * @param $type
     * @return Nucleus
     */
    public function type($type) {
        // Populate and return for chaining
        return $this->setType($type);
    }

    /**
     * @param $policies
     * @return Nucleus
     * @throws \Exception
     */
    public function policies($policies) {
        // Populate and return for chaining
        return $this->setPolicies(new PolicyCollection($policies));
    }

    /**
     * @param $formatters
     * @return Nucleus
     * @throws \Exception
     */
    public function formatters($formatters) {
        // Populate and return for chaining
        return $this->setFormatters(new FormatterCollection($formatters));
    }

    /**
     * @param $sanitizers
     * @return Nucleus
     * @throws \Exception
     */
    public function sanitizers($sanitizers) {
        // Populate and return for chaining
        return $this->setSanitizers(new SanitizerCollection($sanitizers));
    }

    /**
     * @param $validators
     * @return Nucleus
     * @throws \Exception
     */
    public function validators($validators) {
        // Populate and return for chaining
        return $this->setValidators(new ValidatorCollection($validators));
    }

    /**
     * @param $nuclei
     * @return Nucleus
     * @throws \Exception
     */
    public function nuclei($nuclei) {
        // Populate and return for chaining
        return $this->setNuclei(new NucleusCollection($nuclei));
    }

}