<?php
/**
 * @author Jon West
 */

namespace Celestial\Lexicology\Method;

use Celestial\Lexicology\Method\Interfaces\FilterInterface;
use Celestial\Lexicology\Method\Interfaces\SortInterface;
use Celestial\Lexicology\Method\Traits\SortTrait;

class Soundex extends AbstractMethod implements SortInterface, FilterInterface
{
    use SortTrait;

    protected $soundex;

    public function setField($field)
    {
        $this->soundex = soundex($field);
        return parent::setField($field);
    }

    /**
     * @param string $a
     * @param string $b
     * @return int|null
     */
    public function sortPair($a, $b)
    {
        $soundexA = soundex($a);
        $soundexB = soundex($b);

        if ($soundexA === $soundexB) {
            return 0;
        } elseif ($soundexA === $this->soundex) {
            return -1;
        } elseif ($soundexB === $this->soundex) {
            return 1;
        }
        return null;
    }

    /**
     * @param array $possibleValues
     * @return array
     */
    public function filter($possibleValues)
    {
        $soundexField = $this->soundex;
        return array_values(array_filter($possibleValues,
            function ($value) use ($soundexField) {
                return (soundex($value) === $soundexField);
            }
        ));
    }
}