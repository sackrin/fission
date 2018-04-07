<?php

namespace Fission\Diff;

class Snapshot {

    /**
     * @var Snapshot
     */
    protected $previous;

    /**
     * @var array
     */
    protected $values;

    /**
     * @var array
     */
    protected $added;

    /**
     * @var array
     */
    protected $updated;

    /**
     * @var array
     */
    protected $removed;

    /**
     * Snapshot constructor.
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * @return Snapshot
     */
    public function getPrevious(): Snapshot
    {
        return $this->previous;
    }

    /**
     * @param Snapshot $previous
     * @return Snapshot
     */
    public function setPrevious(Snapshot $previous): Snapshot
    {
        $this->previous = $previous;
        return $this;
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param array $values
     * @return Snapshot
     */
    public function setValues(array $values): Snapshot
    {
        $this->values = $values;
        return $this;
    }

    public function previous(Snapshot $previous) {

        $this->previous = $previous;

        $this->added = static::walkAdded($this->values, $previous);
//        $this->updated = static::walkUpdated($this->values, $previous);
//        $this->removed = static::walkRemoved($this->values, $previous);

        return $this;
    }

    public function hash() {

    }

    public static function walkAdded($values, $previous) {
        die('asdasd');
    }

    public static function walkUpdated($values, $previous) {
        die('asdasd');
    }

    public static function walkRemoved($values, $previous) {

    }
}