<?php

namespace Fission\Resolve;

use Fission\Fission;
use Fission\Schema\Policy\PolicyCollection;
use Fission\Schema\Sanitize\SanitizeCollection;

class ArrayResolver {

    public $arr;

    public static function from($arr) {
        return (new static($arr))->build();
    }

    public function __construct($arr) {
        $this->arr = $arr;
    }

    public function build() {
        $nuclie = $this->walker($this->arr);
        die(print_r($nuclie));
        return $this;
    }

    public function walker($arr) {

        $collect = Fission::configCollect([]);

        foreach ($arr as $import) {

            $nucleus = Fission::configNucleus($import['machine']);

            $nucleus->type($import['type']);

            if ($import['label']) {
                static::addPolicies($nucleus, $import['label']);
            }

            if ($import['policies'] && is_array($import['policies'])) {
                static::addPolicies($nucleus, $import['policies']);
            }

            if ($import['sanitize'] && is_array($import['sanitize'])) {
                static::addSanitize($nucleus, $import['sanitize']);
            }

            if ($import['validate'] && is_array($import['validate'])) {
                static::addValidate($nucleus, $import['validate']);
            }

            if ($import['nuclei'] && is_array($import['nuclei'])) {
                static::addNuclei($nucleus, $this->walker($import['nuclei']));
            }

            $collect->add($nucleus);
        }

        return $collect;
    }

    public static function addPolicies($nucleus, $items) {

        $policies = new PolicyCollection([]);

        foreach ($items as $item) {

            $policy = Fission::configPolicy($item['type'], $item['for']);

            $policy->scope($item['scope'])->roles($item['for']);

            $policies->add($policy);
        }

        $nucleus->policies($policies);
    }

    public static function addSanitize($nucleus, $items) {

        $sanitizers = new SanitizeCollection([]);

        foreach ($items as $item) {

            $sanitizer = Fission::configSanitize($item['type'], $item['using']);

            $sanitizers->add($sanitizer);
        }

        $nucleus->sanitize($sanitizers);
    }

    public static function addValidate($nucleus, $items) {

        $validators = new SanitizeCollection([]);

        foreach ($items as $item) {

            $validator = Fission::configValidate($item['type'], $item['against']);

            $validators->add($validator);
        }

        $nucleus->validate($validators);
    }

    public static function addNuclei($nucleus, $nuclei) {

        $nucleus->nuclei($nuclei);
    }
}