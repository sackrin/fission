<?php

namespace Fission\Isotope;

use Doctrine\Common\Collections\ArrayCollection;
use Fission\Nucleus\HasNucleiTrait;
use Fission\Reactor;
use Fission\Nucleus\NucleiCollection;
use Fission\Policy\HasRolesTrait;
use Fission\Policy\HasScopeTrait;
use Fission\Support\Type;

class IsotopeCollection extends ArrayCollection {

    use HasRolesTrait, HasScopeTrait, HasIsotopesTrait, HasNucleiTrait;

    /**
     * @var Reactor
     */
    public $reactor;

    /**
     * IsotopeCollection constructor.
     * @param Reactor $reactor
     * @param NucleiCollection $nuclei
     */
    public function __construct(Reactor $reactor, $nuclei) {
        // Populate the reactor instance
        $this->reactor = $reactor;
        // Populate the nuclei collection
        $this->nuclei = new NucleiCollection($nuclei);
        // Do not allow for isotope injection
        // All isotopes must be generated via hydrate
        parent::__construct([]);
    }

    /**
     * @return Reactor
     */
    public function getReactor() {
        // Return the reactor instance
        return $this->reactor;
    }

    /**
     * @param Reactor $reactor
     * @return IsotopeCollection
     */
    public function setReactor(Reactor $reactor) {
        // Set the reactor instance
        $this->reactor = $reactor;
        // Return for chaining
        return $this;
    }

    /**
     * Spawn New Collection
     * @param NucleiCollection $nuclei
     * @return $this
     * @throws \Exception
     */
    public function spawn(NucleiCollection $nuclei) {
        // Return a newly minted isotope collection instance
        return (new IsotopeCollection($this->reactor, $nuclei))
            ->setScope($this->scope)
            ->setRoles($this->roles);
    }

    /**
     * Hydrate Walker
     * @param $values
     * @return $this
     * @throws \Exception
     */
    public function hydrate($values) {
        // Loop through each of the nuclei
        foreach ($this->nuclei as $nucleus) {
            // Retrieve the nucleus machine code
            // Field names should always match the machine code
            $machine = $nucleus->getMachine();
            // Retrieve any data passed for this nucleus
            $value = isset($values[$machine]) ? $values[$machine] : null;
            // Create a new isotope instance
            $isotope = Isotope::create($this->getReactor(), $nucleus)
                ->setSiblings($this->getNuclei())
                ->setValue($value)
                ->sanitize();
            // Check the policies to see if isotope hydration is allowed
            $grant = $nucleus->policies
                ->grant($isotope, $this->getScope(), $this->getRoles());
            // If the property was not granted
            if (!$grant) { continue; }
            // If this nuclues is a container
            // This means it will have direct property isotopes
            if ($nucleus->type === Type::container()) {
                // Build a new isotope collection
                $collect = $this->spawn($nucleus->getNuclei())
                    ->hydrate($isotope->getValue());
                // Generate property isotopes and store
                $isotope->isotopes($collect);
            } // Otherwise if this nucleus is a collection
            // Which means this will have multiple groups of isotopes
            elseif ($nucleus->type === Type::collection() && is_array($isotope->getValue())) {
                // Loop through each of the value groups
                foreach ($isotope->getValue() as $_value) {
                    // Build a new isotope collection
                    $collect = $this->spawn($nucleus->getNuclei())
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