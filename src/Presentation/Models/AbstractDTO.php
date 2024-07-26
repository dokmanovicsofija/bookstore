<?php

namespace src\Presentation\Models;

/**
 * Class AbstractDTO
 *
 * An abstract class providing common functionality for entity models.
 */
abstract class AbstractDTO
{
    /**
     * Converts the entity object to an associative array.
     *
     * @return array The associative array representation of the entity.
     */
    abstract public function toArray(): array;

    /**
     * Creates an array of objects from a batch of data.
     *
     * @param array $batch
     * @return self[]
     */
    public static function fromBatch(array $batch): array
    {
        $entities = [];
        foreach ($batch as $item) {
            $entities[] = new static(...array_values($item));
        }
        return $entities;
    }
}
