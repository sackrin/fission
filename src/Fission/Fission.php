<?php

namespace Fission;

use Fission\Format\FormatterCollection;
use Fission\Format\FormatTo;
use Fission\Nucleus\Nucleus;
use Fission\Nucleus\NucleiCollection;
use Fission\Policy\Allow;
use Fission\Policy\Deny;
use Fission\Policy\PolicyCollection;
use Fission\Sanitize\GUMPSanitizer;
use Fission\Sanitize\SanitizerCollection;
use Fission\Validate\GUMPValidator;
use Fission\Validate\ValidatorCollection;
use Fission\Support\Collect;

class Fission {

    public static $config = [
        'nucleus' => Nucleus::class,
        'nuclei' => NucleiCollection::class,
        'collect' => Collect::class,
        'policies' => [
            'default' => PolicyCollection::class
        ],
        'policy' => [
            'deny' => Deny::class,
            'allow' => Allow::class
        ],
        'formatters' => [
            'default' => FormatterCollection::class
        ],
        'formatter' => [
            'default' => FormatTo::class
        ],
        'sanitizers' => [
            'default' => SanitizerCollection::class
        ],
        'sanitizer' => [
            'default' => GUMPSanitizer::class
        ],
        'validators' => [
            'default' => ValidatorCollection::class
        ],
        'validator' => [
            'default' => GUMPValidator::class
        ]
    ];

    public static function configNucleus($machine) {
        $class = static::$config['nucleus'];
        return new $class($machine);
    }

    public static function configNuclei($machine) {
        $class = static::$config['nuclei'];
        return new $class($machine);
    }

    public static function configCollect($elements = []) {
        $class = static::$config['collect'];
        return new $class($elements);
    }

    public static function configPolicies($type='default', $elements = []) {
        $class = static::$config['policies'][$type];
        return new $class($elements);
    }

    public static function configPolicy($type) {
        $class = static::$config['policy'][$type];
        return new $class();
    }

    public static function configFormatters($type='default', $elements = []) {
        $class = static::$config['formatters'][$type];
        return new $class($elements);
    }

    public static function configFormatter($type, $using) {
        $class = static::$config['formatter'][$type];
        return new $class($using);
    }

    public static function configSanitizers($type='default', $elements = []) {
        $class = static::$config['sanitizers'][$type];
        return new $class($elements);
    }

    public static function configSanitizer($type, $using) {
        $class = static::$config['sanitizer'][$type];
        return new $class($using);
    }

    public static function configValidators($type='default', $elements = []) {
        $class = static::$config['validators'][$type];
        return new $class($elements);
    }

    public static function configValidator($type, $against) {
        $class = static::$config['validator'][$type];
        return new $class($against);
    }

}