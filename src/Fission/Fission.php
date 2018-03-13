<?php

namespace Fission;

use Fission\Schema\Nucleus;
use Fission\Schema\NucleusCollection;
use Fission\Schema\Policy\Allow;
use Fission\Schema\Policy\Deny;
use Fission\Schema\Sanitize\Sanitize;
use Fission\Schema\Validate\GUMPValidate;
use Fission\Support\Collect;

class Fission {

    public static $config = [
        'nucleus' => Nucleus::class,
        'nuclei' => NucleusCollection::class,
        'collect' => Collect::class,
        'policy' => [
            'deny' => Deny::class,
            'allow' => Allow::class
        ],
        'sanitize' => [
            'default' => Sanitize::class
        ],
        'validate' => [
            'default' => GUMPValidate::class
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

    public static function configPolicy($type) {
        $class = static::$config['policy'][$type];
        return new $class();
    }

    public static function configSanitize($type, $using) {
        $class = static::$config['sanitize'][$type];
        return new $class($using);
    }

    public static function configValidate($type, $against) {
        $class = static::$config['validate'][$type];
        return new $class($against);
    }

}