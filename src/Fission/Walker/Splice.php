<?php

namespace Fission\Walker;

use Fission\Schema\Atom;
use Fission\Schema\Nucleus;
use Fission\Schema\NucleusCollection;
use Fission\Support\Collect;
use Fission\Support\Type;

class Splice {

    /**
     * @var Atom
     */
    public $atom;

    /**
     * @var Collect
     */
    public $merge;

    /**
     * @var string
     */
    public $path;

    /**
     * @var bool
     */
    public $isComplete;

    /**
     * Factory Method
     * @param Atom $atom
     * @return static
     * @throws \Exception
     */
    public static function using(Atom $atom) {
        // Return a new instance
        return new static($atom);
    }

    /**
     * Splice constructor.
     * @param Atom $atom
     * @throws \Exception
     */
    public function __construct(Atom $atom) {
        // Store the atom instance
        $this->atom = $atom;
        // Set up merge as a collect instance
        $this->merge = new Collect([]);
    }

    /**
     * Merge
     * @param string $property
     * @param mixed $value
     * @param bool $replace
     * @param string $type
     * @return $this
     */
    public function merge(string $property, $value, bool $replace=false, string $type='auto') {
        // Add the items to the merge list
        $this->merge->add([
            'property' => $property,
            'value' => $value,
            'replace' => $replace,
            'type' => $type
        ]);
        // Return for chaining
        return $this;
    }

    /**
     * At (Path)
     * @param string $path
     * @return Atom
     * @throws \Exception
     */
    public function at(string $path) {
        // Store the path
        $this->path = $path;
        // Reset the is complete bool
        $this->isComplete = false;
        // Initiate the tree walker
        $this->walker($this->atom->nuclei);
        // Reset the merge collection
        // We do this so this instance can be reused
        $this->merge = new Collect([]);
        // Return the merged atom instance
        return $this->atom;
    }

    /**
     * Walker
     * @param NucleusCollection $nuclei
     * @param string $crumb
     * @throws \Exception
     */
    public function walker(NucleusCollection $nuclei, string $crumb='') {
        // If the walker is complete then simply return out
        // This isn't 100% required but saves some compute cycles
        if ($this->isComplete === true) { return; }
        // Loop through each of the nuclei instances
        foreach ($nuclei->toArray() as $nucleus) {
            // Retrieve the nucleus machine code
            $machine = $nucleus->machine;
            // Build the nucleus breadcrumb
            $breadcrumb = $crumb ? $crumb.'.'.$machine : $machine;
            // If this was the path we were looking for
            if ($breadcrumb === $this->path) {
                // //
                $this->applyToNucleus($nucleus);
            } // Otherwise if this has children nuclei then walk those too
            elseif ($nucleus->type === Type::container() || $nucleus->type === Type::collection()) {
                // Run the walker on the child nuclei
                $this->walker($nucleus->nuclei, $breadcrumb);
            }
        }
    }

    /**
     * Apply To Nucleus
     * @param Nucleus $nucleus
     * @throws \Exception
     */
    public function applyToNucleus(Nucleus $nucleus) {
        // Retrieve the merge rules
        $toMerge = $this->merge->toArray();
        // Loop through each of the merge items
        foreach ($toMerge as $item) {
            // Retrieve the property to merge with
            $property = $item['property'];
            // Retrieve the type
            $type = $item['type'];
            // Retrieve if we are replacing or merging
            $replace = $item['replace'];
            // Retrieve the current value of the property
            $existing = $nucleus->{$property};
            // If type is not set to auto then we let the type dictate what to do
            // In order to perform the merge correctly we have make assumptions about the value if type is set to auto
            // As any property can be merged with we have to look at the current value to tells us how to merge
            // If the current value is a collect instance
            if ($type === 'collection' || ($type === 'auto' && $existing instanceof Collect)) {
                // Retrieve the item value
                $nucleus->{$property} = $this->asTypeCollect($existing, $item['value'], $replace);
            } // Otherwise if the current value is a string
            elseif ($type === 'string' || ($type === 'auto' && is_string($existing))) {
                // Retrieve the item value
                $nucleus->{$property} = $this->asTypeString($existing, $item['value'], $replace);
            } // Otherwise if the current value is a float value
            elseif ($type === 'float' || ($type === 'auto' && is_float($existing))) {
                // Retrieve the item value
                $nucleus->{$property} = $this->asTypeFloat($existing, $item['value'], $replace);
            } // Otherwise if the current value is an integer
            elseif ($type === 'int' || ($type === 'auto' && is_int($existing))) {
                // Retrieve the item value
                $nucleus->{$property} = $this->asTypeInt($existing, $item['value'], $replace);
            } // Otherwise if the current value is a boolean
            elseif ($type === 'bool' || ($type === 'auto' && is_bool($existing))) {
                // Retrieve the item value
                $nucleus->{$property} = $this->asTypeBool($existing, $item['value'], $replace);
            }
        }
    }

    /**
     * As Type Collect
     * @param mixed $existing
     * @param mixed $value
     * @param bool $replace
     * @return Collect
     * @throws \Exception
     */
    public function asTypeCollect($existing, $value, bool $replace) {
        // Retrieve the items to merge or replace
        $value = $value instanceof Collect ? $value->toArray() : (array)$value;
        // If we intend on replacing
        if ($replace) {
            // Overwrite the current instance property
            return $existing->replace($value);
        } // Otherwise merge with the existing values
        else { return $existing->merge($value); }
    }

    /**
     * As Type String
     * @param mixed $existing
     * @param mixed $value
     * @param bool $replace
     * @return string
     */
    public function asTypeString($existing, $value, bool $replace) {
        // Retrieve the items to merge or replace
        $value = (string)$value;
        // If we intend on replacing
        if ($replace) {
            // Overwrite the current instance property
            return $value;
        } // Otherwise merge with the existing values
        else { return $existing.$value; }
    }

    /**
     * As Type Float
     * @param mixed $existing
     * @param mixed $value
     * @param bool $replace
     * @return float
     */
    public function asTypeFloat($existing, $value, bool $replace) {
        // Retrieve the items to merge or replace
        $value = (float)$value;
        // If we intend on replacing
        if ($replace) {
            // Overwrite the current instance property
            return $value;
        } // Otherwise merge with the existing values
        else { return (float)($existing+$value); }
    }

    /**
     * As Type Int
     * @param mixed $existing
     * @param mixed $value
     * @param bool $replace
     * @return int
     */
    public function asTypeInt($existing, $value, bool $replace) {
        // Retrieve the items to merge or replace
        $value = (int)$value;
        // If we intend on replacing
        if ($replace) {
            // Overwrite the current instance property
            return (int)$value;
        } // Otherwise merge with the existing values
        else { return (int)($existing+$value); }
    }

    /**
     * As Type Bool
     * @param mixed $existing
     * @param mixed $value
     * @param bool $replace
     * @return bool
     */
    public function asTypeBool($existing, $value, bool $replace) {
        // Retrieve the items to merge or replace
        return (bool)$value;
    }

}