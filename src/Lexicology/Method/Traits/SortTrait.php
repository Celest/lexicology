<?php
/**
 * @author Jon West
 */

namespace Celestial\Lexicology\Method\Traits;


trait SortTrait
{
    /**
     * @param array $possibleValues
     * @return array
     */
    public function sort($possibleValues)
    {
        usort($possibleValues, [$this, 'sortPair']);
        return $possibleValues;
    }
}