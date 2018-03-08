<?php

namespace Fission\Hydrate;

use Doctrine\Common\Collections\ArrayCollection;
use Fission\Schema\Policy\Traits\HasRoles;
use Fission\Schema\Policy\Traits\HasScope;
use Fission\Support\Type;

class IsotopeCollection extends ArrayCollection {

    use HasRoles, HasScope;

    public $nuclei;

    public $isotopes;

    public function __construct($nuclei, array $elements = []) {
        // Store the nuclei collection
        $this->nuclei = $nuclei;
        // Pass any currently generated isotopes
        parent::__construct($elements);
    }

    public function spawn($nuclei) {
        // Return a newly minted isotope collection instance
        return (new IsotopeCollection($nuclei, []))
            ->scope($this->scope)
            ->roles($this->roles);
    }

    public function hydrate($values) {
        // Loop through each of the nuclei
        foreach ($this->nuclei as $nucleus) {
            // Check the policies to see if isotope hydration is allowed
            $grant = $nucleus->policies
                ->grant($this->scope, $this->roles);
            // If the property was not granted
            if (!$grant) { continue; }
            // Retrieve the nucleus machine code
            // Field names should always match the machine code
            $machine = $nucleus->machine;
            // Retrieve any data passed for this nucleus
            $value = isset($values[$machine]) ? $values[$machine] : null;
            // Create a new isotope instance
            $isotope = Isotope::create($nucleus)
                ->value($value)
                ->sanitize();
            // If this nuclues is a container
            // This means it will have direct property isotopes
            if ($nucleus->type === Type::container()) {
                // Build a new isotope collection
                $collect = $this->spawn($nucleus->nuclei)
                    ->hydrate($isotope->value);
                // Generate property isotopes and store
                $isotope->isotopes($collect);
            } // Otherwise if this nucleus is a collection
            // Which means this will have multiple groups of isotopes
            elseif ($nucleus->type === Type::collection() && is_array($isotope->value)) {
                // Loop through each of the value groups
                foreach ($isotope->value as $_value) {
                    // Build a new isotope collection
                    $collect = $this->spawn($nucleus->nuclei)
                        ->hydrate($_value);
                    // Add the isotope group to the isotope collection
                    $isotope->isotopes->add($collect);
                }
            }
            // Add the built isotope to the isotope collection
            $this->add($isotope);
        }
        // Return for chaining
        return $this;
    }

}