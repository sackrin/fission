<?php

namespace Fission\Nucleus;

use Fission\Format\FormatterCollection;
use Fission\Format\HasFormattersTrait;
use Fission\Policy\PolicyCollection;
use Fission\Sanitize\HasSanitizersTrait;
use Fission\Sanitize\SanitizerCollection;
use Fission\Validate\HasValidatorsTrait;
use Fission\Validate\ValidatorCollection;
use Fission\Support\Type;

class Nucleus {

    use HasSanitizersTrait, HasValidatorsTrait, HasFormattersTrait, HasNucleiTrait;

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
     * @var Nucleus
     */
    public $parent;

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
        $this->setPolicies(new PolicyCollection([]));
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

}