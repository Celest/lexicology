<?php
/**
 * @author Jon West
 */

namespace Lexicology\Method;

use Lexicology\Method\Interfaces\FilterInterface;
use Lexicology\Method\Interfaces\RateInterface;

class PregGrep extends AbstractMethod implements RateInterface, FilterInterface
{
    /**
     * @param string $a
     * @param string $b
     * @return int|null
     */
    public function rate($a, $b)
    {
        $quotedField = preg_replace('/[\s\_]/', '.*', '~' . preg_quote($this->getField(), '~') . '~i');

        $pregMatchA = preg_match($quotedField, $a) === 1;
        $pregMatchB = preg_match($quotedField, $b) === 1;

        if ($pregMatchA === $pregMatchB) {
            return 0;
        } else {
            if ($pregMatchA) {
                return 1;
            } elseif ($pregMatchB) {
                return -1;
            }
        }
        return null;
    }

    /**
     * @param array $possibleValues
     * @return array
     */
    public function filter($possibleValues)
    {
        $quotedValue = preg_replace('/[\s\_]/', '.*', '~' . preg_quote($this->getField(), '~') . '~i');
        return array_values(preg_grep($quotedValue, $possibleValues));
    }
}