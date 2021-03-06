<?php
/**
 * @author Jon West
 */

namespace Celestial\Lexicology\Method\Interfaces;

/**
 * Interface FilterInterface
 * @package Lexicology\Method\Interfaces
 */
interface FilterInterface
{
    /**
     * @param array $possibleValues
     * @return array
     */
    public function filter($possibleValues);
}