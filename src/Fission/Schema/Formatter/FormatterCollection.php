<?php

namespace Fission\Schema\Formatter;

use Fission\Hydrate\Isotope;
use Fission\Hydrate\Reactor;
use Fission\Support\Collect;

class FormatterCollection extends Collect {

    /**
     * Isotope Value Getter
     * Use this to get a value from an isotope
     * @param Isotope $isotope
     * @return mixed
     */
    public function getter(Isotope $isotope, $formatted=true) {
        // Retrieve the list of formatters
        $formatters = $this->toArray();
        // If there are no format then just return the value
        if (!$formatted || count($formatters) == 0) { return $isotope->value; }
        // Loop through each of the format
        foreach ($formatters as $formatter) {
            // If the formatter class does not have a get method
            if (!method_exists($formatter, 'get')) { continue; }
            // Pass the value through the formatter method
            $value = $formatter::get($isotope->value, $isotope);
        }
        // Return the result
        return $value;
    }

    /**
     * Isotope Value Setter
     * @param Isotope $isotope
     * @param $value
     * @return mixed
     */
    public function setter(Isotope $isotope, $value, $formatted=true) {
        // Retrieve the list of formatters
        $formatters = $this->toArray();
        // If there are no format then just return the value
        if (!$formatted || count($formatters) == 0) { return $value; }
        // Loop through each of the format
        foreach ($formatters as $formatter) {
            // If the formatter class does not have a set method
            if (!method_exists($formatter, 'set')) { continue; }
            // Pass the value through the formatter method
            $value = $formatter::set($value, $isotope);
        }
        // Return the result
        return $value;
    }

}