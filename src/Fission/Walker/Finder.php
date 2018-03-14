<?php

namespace Fission\Walker;

use Fission\Hydrate\Isotope;
use Fission\Hydrate\IsotopeCollection;
use Fission\Support\Collect;
use Fission\Support\Type;

class Finder {

    /**
     * @var IsotopeCollection
     */
    public $isotopes;

    /**
     * @var array
     */
    protected $paths;

    /**
     * Factory Method
     * @param IsotopeCollection $isotopes
     * @return static
     */
    public static function using(IsotopeCollection $isotopes) {
        // Return a new finder instance
        return new static($isotopes);
    }

    /**
     * Finder constructor.
     * @param IsotopeCollection $isotopes
     */
    public function __construct(IsotopeCollection $isotopes) {
        // Populate the list of isotopes
        $this->setIsotopes($isotopes);
    }

    /**
     * @return IsotopeCollection
     */
    public function getIsotopes() {
        // Return stored isotope collection
        return $this->isotopes;
    }

    /**
     * @param IsotopeCollection $isotopes
     * @return Finder
     */
    public function setIsotopes(IsotopeCollection $isotopes) {
        // Populate the isotope collection
        $this->isotopes = $isotopes;
        // Return for chaining
        return $this;
    }

    /**
     * @param $paths
     * @return $this
     */
    public function find($paths) {
        // Populate the path to look for
        $this->paths = is_string($paths) ? [$paths] : $paths;
        // Return for chaining
        return $this;
    }

    /**
     * @param $paths
     * @return $this
     */
    public function and($paths) {
        // Populate the paths to look for
        $this->paths = array_merge($this->paths, is_string($paths) ? [$paths] : $paths);
        // Return for chaining
        return $this;
    }

    /**
     * @return Collect
     * @throws \Exception
     */
    public function get() {
        // Create a new bag of finding
        $bag = new Collect([]);
        // Initate the tree walking
        $this->walker($this->getIsotopes(), '', $bag);
        // Return bag of finding
        return $bag;
    }

    /**
     * Tree Walker
     * @param IsotopeCollection $isotopes
     * @param string $crumb
     */
    public function walker(IsotopeCollection $isotopes, string $crumb='', Collect $bag) {
        // Loop through each of the isotope instances
        foreach ($isotopes->toArray() as $isotope) {
            // Retrieve the isotope's nucleus
            $nucleus = $isotope->getNucleus();
            // Retrieve the isotopes's nucleus machine code
            $machine = $nucleus->getMachine();
            // Build the nucleus breadcrumb
            $breadcrumb = $crumb ? $crumb.'.'.$machine : $machine;
            // If this was the path we were looking for
            if (in_array($breadcrumb, $this->paths)) {
                // Add to the bag of finding
                $bag->add($isotope);
            } // Otherwise if this has children nuclei then walk those too
            elseif ($nucleus->getType() === Type::container()) {
                // Run the walker on the child nuclei
                $this->walker($isotope->getIsotopes(), $breadcrumb, $bag);
            }  // Otherwise if this has children nuclei then walk those too
            elseif ($nucleus->type === Type::collection()) {
                // Loop through each of the value groups
                foreach ($isotope->getIsotopes() as $k => $_isotopes) {
                    // Run the walker on the isotope isotopes collection
                    $this->walker($_isotopes, $breadcrumb.'.'.$k, $bag);
                }
            }
        }
    }

}