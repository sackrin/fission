<?php

namespace Fission\Support;

use Fission\Fission;
use Fission\Atom;
use Fission\Nucleus\Nucleus;

class ArrayImport {

    /**
     * @var array
     */
    public $import;

    /**
     * @var Atom
     */
    public $atom;

    /**
     * Factory Method
     * @param $import
     * @return mixed
     * @throws \Exception
     */
    public static function from($import) {
        // Return a freshly built atom instance
        return (new static($import))->build();
    }

    /**
     * ArrayImport constructor.
     * @param array $import
     */
    public function __construct(array $import) {
        // Set import data
        $this->setImport($import);
    }

    /**
     * @return array
     */
    public function getImport() {
        // Return stored import data
        return $this->import;
    }

    /**
     * @param array $import
     * @return ArrayImport
     */
    public function setImport(array $import) {
        // Set import data
        $this->import = $import;
        // Return for chaining
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAtom() {
        // Return stored atom instance
        return $this->atom;
    }

    /**
     * @param mixed $atom
     * @return ArrayImport
     */
    public function setAtom(Atom $atom) {
        // Set the atom instance
        $this->atom = $atom;
        // Return for chaining
        return $this;
    }

    /**
     * Atom Builder
     * @return Atom
     * @throws \Exception
     */
    public function build() {
        // Retrieve data to import
        $import = $this->getImport();
        // If no machine code was present
        // The Atom instance needs to have a machine code
        if (!isset($import['machine'])) {
            // Throw a helpful exception
            throw new \Exception('Import Atom needs to define a machine name');
        }
        // Retrieve passed allowed scope and roles
        $scope = isset($import['scope']) ? (array)$import['scope'] : [];
        $roles = isset($import['roles']) ? (array)$import['roles'] : [];
        // Retrieve passed nuclei
        $nuclei = isset($import['nuclei']) ? $import['nuclei'] : [];
        // Build a new atom instance with passed roles and scope
        $atom = (new Atom($import['machine']))
            ->setRoles($roles)
            ->setScope($scope)
            ->nuclei($this->walker($nuclei));
        // Return the newly built Atom instance
        return $atom;
    }

    /**
     * Nucleus Walker
     * @param $items
     * @return mixed
     * @throws \Exception
     */
    public function walker($items) {
        // Retrieve a new nuclei collection instance
        $nuclei = Fission::configNuclei([]);
        // Loop through all of the passed items
        foreach ($items as $import) {
            // Create a new nucleus instance using the fission config
            $nucleus = Fission::configNucleus($import['machine']);
            // Set the nucleus type
            $nucleus->type($import['type']);
            // Inject any passed nucleus data
            static::addLabel($nucleus, isset($import['label']) ? $import['label'] : null );
            static::addFormatters($nucleus, isset($import['formatters']) ? $import['formatters'] : null );
            static::addPolicies($nucleus, isset($import['policies']) ? $import['policies'] : null );
            static::addSanitizers($nucleus, isset($import['sanitizers']) ? $import['sanitizers'] : null );
            static::addValidators($nucleus, isset($import['validators']) ? $import['validators'] : null );
            static::addNuclei($nucleus, isset($import['nuclei']) ? $this->walker($import['nuclei']) : null);
            // Add the built nucleus instance to the nuclei collection
            $nuclei->add($nucleus);
        }
        // Return the built nuclei
        return $nuclei;
    }

    /**
     * Add Nucleus Label
     * @param Nucleus $nucleus
     * @param $label
     */
    public static function addLabel(Nucleus $nucleus, $label) {
        // If null was passed then return out
        if ($label === null) { return; }
        // Add the label value to the nucleus instance
        $nucleus->label($label);
    }

    /**
     * Add Policies
     * @param Nucleus $nucleus
     * @param $items
     * @throws \Exception
     */
    public static function addPolicies(Nucleus $nucleus, $items) {
        // If null was passed then return out
        if ($items === null) { return; }
        // Determine the context of the collection
        $items = isset($items['items']) ? $items['items'] : $items ;
        $type = isset($items['type']) ? $items['type'] : 'default' ;
        // Create a new policy collection
        $policies = Fission::configPolicies($type, []);
        // Loop through each of the provided items
        foreach ($items as $item) {
            // Create a new policy instance
            $policy = Fission::configPolicy($item['type']);
            // Add scope and roles to policy instance
            $policy->setScope($item['scope'])->setRoles($item['for']);
            // Add built policy to policy collection
            $policies->add($policy);
        }
        // Add the policy collection to the nucleus
        $nucleus->policies($policies);
    }

    /**
     * Add Nucleus Formatters
     * @param Nucleus $nucleus
     * @param $items
     * @throws \Exception
     */
    public static function addFormatters(Nucleus $nucleus, $items) {
        // If null was passed then return out
        if ($items === null) { return; }
        // Determine the context of the collection
        $items = isset($items['items']) ? $items['items'] : $items ;
        $type = isset($items['type']) ? $items['type'] : 'default' ;
        // Create a new formatter collection
        $formatters = Fission::configFormatters($type, []);
        // Loop through each of the passed items
        foreach ($items as $item) {
            // Create a new formatter instance
            $formatter = Fission::configFormatter($item['type'], isset($item['options']) ? $item['options'] : null);
            // Add the formatter instance to the list of formatters
            $formatters->add($formatter);
        }
        // Add the formatter collection to the nucleus instance
        $nucleus->formatters($formatters);
    }

    /**
     * Add Nucleus Sanitizers
     * @param Nucleus $nucleus
     * @param $items
     * @throws \Exception
     */
    public static function addSanitizers(Nucleus $nucleus, $items) {
        // If null was passed then return out
        if ($items === null) { return; }
        // Determine the context of the collection
        $items = isset($items['items']) ? $items['items'] : $items ;
        $type = isset($items['type']) ? $items['type'] : 'default' ;
        // Create a new santizer collection
        $sanitizers = Fission::configSanitizers($type, []);
        // Loop through each of the passed sanitizer items
        foreach ($items as $item) {
            // Create a new sanitizer instance
            $sanitizer = Fission::configSanitizer($item['type'], isset($item['options']) ? $item['options'] : null);
            // Add the sanitizer to the sanitizer collection
            $sanitizers->add($sanitizer);
        }
        // Add the sanitizer collection to the nucleus
        $nucleus->sanitizers($sanitizers);
    }

    /**
     * Add Nucleus Validators
     * @param Nucleus $nucleus
     * @param $items
     * @throws \Exception
     */
    public static function addValidators(Nucleus $nucleus, $items) {
        // If null was passed then return out
        if ($items === null) { return; }
        // Determine the context of the collection
        $items = isset($items['items']) ? $items['items'] : $items ;
        $type = isset($items['type']) ? $items['type'] : 'default' ;
        // Create a new validator collection
        $validators = Fission::configValidators($type, []);
        // Loop through each of the passed items
        foreach ($items as $item) {
            // Create a new validator instance
            $validator = Fission::configValidator($item['type'], isset($item['options']) ? $item['options'] : null);
            // Add the validator instance to the list of validators
            $validators->add($validator);
        }
        // Add the validator collection to the nucleus instance
        $nucleus->validators($validators);
    }

    /**
     * Add Nucleus Child Nuclei
     * @param Nucleus $nucleus
     * @param $nuclei
     * @throws \Exception
     */
    public static function addNuclei(Nucleus $nucleus, $nuclei) {
        // If null was passed then return out
        if ($nuclei === null) { return; }
        // Set the nuclei into the nucleus
        $nucleus->nuclei($nuclei);
    }
}