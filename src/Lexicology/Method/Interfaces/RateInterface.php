<?php
/**
 * @author Jon West
 */

namespace Lexicology\Method\Interfaces;

/**
 * Interface RateInterface
 * @package Lexicology\Method\Interfaces
 */
interface RateInterface
{
    /**
     * @param string $a
     * @param string $b
     * @return int|null
     */
    public function rate($a, $b);
}