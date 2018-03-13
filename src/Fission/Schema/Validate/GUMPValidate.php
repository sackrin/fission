<?php

namespace Fission\Schema\Validate;

use Fission\Hydrate\Isotope;
use GUMP;

class GUMPValidate extends AbstractValidate {

    /**
     * @var string
     */
    public $rules;

    /**
     * Factory Method
     * @param $rules
     * @return static
     */
    public static function against($rules) {
        // Return new constructed instance
        return new static($rules);
    }

    /**
     * Validate constructor.
     * @param $rules
     */
    public function __construct($rules) {
        // Populate provided rules
        $this->rules = $rules;
    }

    /**
     * Validate Value
     * @param Isotope $isotope
     * @param $value
     * @return array|bool
     * @throws \Exception
     */
    public function validate(Isotope $isotope, $value) {
        // Create a new gump instance
        $gump = new GUMP();
        // Generate a temporary file field name
        $tmp = uniqid();
        // Setup the validation rules
        $gump->validation_rules([$tmp => $this->rules]);
        // If the validation failed
        if ($gump->run([$tmp => $value]) === false) {
            // Retrieve the list of errors
            $errors = $gump->get_errors_array();
            // A nice list to store the errors
            $list = [];
            // Loop through any errors given
            foreach ($errors as $error) {
                // Add the error message to the list
                // Have to strip out the tmp field name and remove any double up spaces
                $list[] =  preg_replace('/ +/', ' ', str_ireplace($tmp, '', $error));
            }
            // Return in an array
            // We have to do this to let other rules return multiple
            return $list;
        } // Otherwise return true
        else { return true; }
    }

}
