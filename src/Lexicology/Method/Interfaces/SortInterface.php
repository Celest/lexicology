<?php
/**
 * @author Jon West
 */

namespace Celestial\Lexicology\Method\Interfaces;

/**
 * Interface SortInterface
 * @package Lexicology\Method\Interfaces
 */
interface SortInterface
{
    /**
     * @param string $a
     * @param string $b
     * @return int|null
     */
    public function sortPair($a, $b);

    /**
     * @param array $possibleValues
     * @return array
     */
    public function sort($possibleValues);
}