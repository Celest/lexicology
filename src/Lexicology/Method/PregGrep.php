<?php
/**
 * @author Jon West
 */

namespace Celestial\Lexicology\Method;

use Celestial\Lexicology\Method\Interfaces\FilterInterface;
use Celestial\Lexicology\Method\Interfaces\SortInterface;
use Celestial\Lexicology\Method\Traits\SortTrait;

class PregGrep extends AbstractMethod implements SortInterface, FilterInterface
{
    use SortTrait;

    /**
     * @param string $a
     * @param string $b
     * @return int|null
     */
    public function sortPair($a, $b)
    {
        $quotedField = preg_replace('/[\s\_]/', '.*', '~' . preg_quote($this->getField(), '~') . '~i');

        $pregMatchA = preg_match($quotedField, $a) === 1;
        $pregMatchB = preg_match($quotedField, $b) === 1;

        if (true === $pregMatchA && $pregMatchA === $pregMatchB) {
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