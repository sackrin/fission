<?php

namespace Fission\Format;

use Fission\Isotope\Isotope;

interface FormatterInterface {

    /**
     * Value Getter
     * @param Isotope $isotope
     * @param $value
     * @return mixed
     */
    public function get(Isotope $isotope, $value);

    /**
     * Value Setter
     * @param Isotope $isotope
     * @param $value
     * @return mixed
     */
    public function set(Isotope $isotope, $value);

}
