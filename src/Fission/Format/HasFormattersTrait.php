<?php

namespace Fission\Format;

trait HasFormattersTrait {

    /**
     * @var FormatterCollection
     */
    public $formatters;

    /**
     * @return FormatterCollection
     */
    public function getFormatters() {
        // Return the formatterster collection
        return $this->formatters instanceof FormatterCollection ? $this->formatters : new FormatterCollection([]);
    }

    /**
     * @param FormatterCollection $formatters
     * @return $this
     */
    public function setFormatters(FormatterCollection $formatters) {
        // Set the formatterster collection
        $this->formatters = $formatters;
        // Return for chaining
        return $this;
    }

    /**
     * @param $formatters
     * @return $this
     * @throws \Exception
     */
    public function formatters($formatters) {
        // Populate and return for chaining
        return $this->setFormatters(new FormatterCollection($formatters));
    }
}
