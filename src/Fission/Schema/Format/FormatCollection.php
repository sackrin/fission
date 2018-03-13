<?php

namespace Fission\Schema\Format;

use Fission\Hydrate\Isotope;
use Fission\Hydrate\Reactor;
use Fission\Support\Collect;

class FormatCollection extends Collect {

    /**
     * @param Isotope $isotope
     * @return mixed
     */
    public function getter(Isotope $isotope) {
        // Retrieve the list of format
        $format = $this->toArray();
        // If there are no format then just return the value
        if (count($format) == 0) { return $isotope->value; }
        // Loop through each of the format
        foreach ($format as $formatter) {
            // If the formatter class does not have a get method
            if (!method_exists($formatter, 'get')) { continue; }
            // Pass the value through the formatter method
            $value = $formatter::get($isotope->value, $isotope);
        }
        // Return the result
        return $value;
    }

    /**
     * @param Isotope $isotope
     * @param $value
     * @return mixed
     */
    public function setter(Isotope $isotope, $value) {
        // Retrieve the list of format
        $format = $this->toArray();
        // If there are no format then just return the value
        if (count($format) == 0) { return $value; }
        // Loop through each of the format
        foreach ($format as $formatter) {
            // If the formatter class does not have a set method
            if (!method_exists($formatter, 'set')) { continue; }
            // Pass the value through the formatter method
            $value = $formatter::set($value, $isotope);
        }
        // Return the result
        return $value;
    }

}