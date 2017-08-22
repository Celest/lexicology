<?php
/**
 * @author Jon West
 */

namespace Lexicology\Method;

use Lexicology\Method\Interfaces\FilterInterface;
use Lexicology\Method\Interfaces\RateInterface;

class Soundex extends AbstractMethod implements RateInterface, FilterInterface
{
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
    public function rate($a, $b)
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