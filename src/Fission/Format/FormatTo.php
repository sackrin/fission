<?php

namespace Fission\Format;

use Fission\Isotope\Isotope;

class FormatTo implements FormatterInterface {

    /**
     * @var string
     */
    public $type;

    public static function type(string $type) {
        // Build and return a new instance
        return new static($type);
    }

    public function __construct(string $type) {
        // Store the format type
        $this->setType($type);
    }

    /**
     * @return string
     */
    public function getType() {
        // Return the stored type
        return $this->type;
    }

    /**
     * @param string $type
     * @return FormatTo
     */
    public function setType(string $type) {
        // Store the format type
        $this->type = $type;
        // Return for chaining
        return $this;
    }

    /**
     * Value Getter
     * @param Isotope $isotope
     * @param $value
     * @return mixed
     */
    public function get(Isotope $isotope, $value) {
        // Determine how to convert the value
        switch ($this->getType()) {
            case 'string': $value = (string)$value; break;
            case 'array': $value = (array)$value; break;
            case 'bool': $value = (bool)$value; break;
            case 'int': $value = (int)$value; break;
            case 'float': $value = (float)$value; break;
            case 'json': $value = json_decode($value); break;
            case 'base64': $value = base64_decode($value); break;
        }
        // Return the convert value
        return $value;
    }

    /**
     * Value Setter
     * @param Isotope $isotope
     * @param $value
     * @return mixed
     */
    public function set(Isotope $isotope, $value) {
        // Determine how to convert the value
        switch ($this->getType()) {
            case 'string': $value = (string)$value; break;
            case 'array': $value = (array)$value; break;
            case 'bool': $value = (bool)$value; break;
            case 'int': $value = (int)$value; break;
            case 'float': $value = (float)$value; break;
            case 'json': $value = json_encode($value); break;
            case 'base64': $value = base64_encode($value); break;
        }
        // Return the convert value
        return $value;
    }

}