<?php

namespace Fission\Support;

class Type {

    const STRING = 'string';
    const INT = 'int';
    const BOOLEAN = 'boolean';
    const FLOAT = 'float';
    const CONTAINER = 'container';
    const COLLECTION = 'collection';

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