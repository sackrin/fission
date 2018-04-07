<?php

namespace Fission\Diff;

class Diff {

    /**
     * @var SnapshotCollection
     */
    public $snapshots;

    /**
     * Press constructor.
     * @param $values
     * @throws \Exception
     */
    public function __construct($values) {
        // Preset the snapshot collection
        $this->snapshots = new SnapshotCollection([]);
        // Create as a new snapshot instance
        $snapshot = (new Snapshot((array)$values));
        // Override any existing values
        $this->snapshots->add($snapshot);
    }

    /**
     * Factory Method
     * @param $values
     * @return static
     * @throws \Exception
     */
    public static function values($values) {
        // Return a new press instance
        return new static($values);
    }

    /**
     * Merge Additional Values
     * @param $values
     * @return $this
     */
    public function and($values) {
        // Retrieve the last snapshot
        $previous = $this->snapshots->last();
        // Create as a new snapshot instance
        $snapshot = (new Snapshot((array)$values))
            ->previous($previous);
        // Add to the snapshot collection
        $this->snapshots->add($snapshot);
        // Return for chaining
        return $this;
    }

}