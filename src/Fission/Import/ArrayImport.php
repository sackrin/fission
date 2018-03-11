<?php

namespace Fission\Import;

use Fission\Fission;
use Fission\Schema\Atom;
use Fission\Schema\Nucleus;
use Fission\Schema\Policy\PolicyCollection;
use Fission\Schema\Sanitize\SanitizeCollection;
use Fission\Support\Collect;

class ArrayImport {

    public $import;

    public $atom;

    public static function from($import) {
        return (new static($import))->build();
    }

    public function __construct($import) {
        $this->import = $import;
    }

    public function build() {

        $import = $this->import;

        if (!isset($import['machine'])) {
            throw new \Exception('Import Atom needs to define a machine name');
        }

        $atom = (new Atom($import['machine']))
            ->roles(isset($import['roles']) ? $import['roles'] : [] )
            ->scope(isset($import['scope']) ? $import['scope'] : [] );

        $atom->nuclei($this->walker(isset($import['nuclei']) ? $import['nuclei'] : []));

        return $atom;
    }

    public function walker($arr) {

        $collect = Fission::configCollect([]);

        foreach ($arr as $import) {

            $nucleus = Fission::configNucleus($import['machine']);

            $nucleus->type($import['type']);

            if (isset($import['label'])) {
                static::addLabel($nucleus, $import['label']);
            }

            if (isset($import['policies']) && is_array($import['policies'])) {
                static::addPolicies($nucleus, $import['policies']);
            }

            if (isset($import['sanitize']) && is_array($import['sanitize'])) {
                static::addSanitize($nucleus, $import['sanitize']);
            }

            if (isset($import['validate']) && is_array($import['validate'])) {
                static::addValidate($nucleus, $import['validate']);
            }

            if (isset($import['nuclei']) && is_array($import['nuclei'])) {
                static::addNuclei($nucleus, $this->walker($import['nuclei']));
            }

            $collect->add($nucleus);
        }

        return $collect;
    }

    public static function addLabel(Nucleus $nucleus, $label) {
        $nucleus->label($label);
    }

    public static function addPolicies(Nucleus $nucleus, $items) {

        $policies = new PolicyCollection([]);

        foreach ($items as $item) {

            $policy = Fission::configPolicy($item['type'], $item['for']);

            $policy->scope($item['scope'])->roles($item['for']);

            $policies->add($policy);
        }

        $nucleus->policies($policies);
    }

    public static function addSanitize(Nucleus $nucleus, array $items) {

        $sanitizers = new SanitizeCollection([]);

        foreach ($items as $item) {

            $sanitizer = Fission::configSanitize($item['type'], $item['using']);

            $sanitizers->add($sanitizer);
        }

        $nucleus->sanitize($sanitizers);
    }

    public static function addValidate(Nucleus $nucleus, array $items) {

        $validators = new SanitizeCollection([]);

        foreach ($items as $item) {

            $validator = Fission::configValidate($item['type'], $item['against']);

            $validators->add($validator);
        }

        $nucleus->validate($validators);
    }

    public static function addNuclei(Nucleus $nucleus, Collect $nuclei) {

        $nucleus->nuclei($nuclei);
    }
}