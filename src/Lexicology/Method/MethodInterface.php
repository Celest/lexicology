<?php
/**
 * @author Jon West
 */

namespace Lexicology\Method;

/**
 * Interface MethodInterface
 * @package Lexicology\Method
 */
interface MethodInterface
{
    /**
     * @param string $a
     * @param string $b
     * @return int|null
     */
    public function rate($a, $b);

    /**
     * @param array $possibleValues
     * @return array
     */
    public function filter($possibleValues);
}