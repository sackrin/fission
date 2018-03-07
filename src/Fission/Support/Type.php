<?php

namespace Fission\Support;

class Type {

    const STRING = 'String';
    const INT = 'Int';
    const BOOLEAN = 'Boolean';
    const FLOAT = 'Float';
    const CONTAINER = 'Container';
    const COLLECTION = 'Collection';

    public static function string() {
        return self::STRING;
    }

    public static function int() {
        return self::INT;
    }

    public static function boolean() {
        return self::BOOLEAN;
    }

    public static function float() {
        return self::FLOAT;
    }

    public static function container() {
        return self::CONTAINER;
    }

    public static function collection() {
        return self::COLLECTION;
    }

}