<?php
/**
 * @author Jon West
 */

namespace Celestial\Lexicology\Method;

use Celestial\Lexicology\Method\Interfaces\FilterInterface;
use Celestial\Lexicology\Method\Interfaces\SortInterface;
use Celestial\Lexicology\Method\Traits\SortTrait;
use Celestial\Lexicology\Method\Traits\ThresholdTrait;

class LevenshteinDistance extends AbstractMethod implements SortInterface, FilterInterface
{
    use ThresholdTrait;
    use SortTrait;

    public function __construct($field, $threshold = 5)
    {
        $this->setThreshold($threshold);
        parent::__construct($field);
    }

    /**
     * @param string $a
     * @param string $b
     * @return int|null
     */
    public function sortPair($a, $b)
    {
        $levenshteinA = levenshtein($a, $this->getField());
        $levenshteinB = levenshtein($b, $this->getField());
        if ($levenshteinA === $levenshteinB) {
            return 0;
        }
        return ($levenshteinA < $levenshteinB) ? -1 : 1;
    }


    /**
     * @param array $possibleValues
     * @return array
     */
    public function filter($possibleValues)
    {
        $threshold = $this->getThreshold();
        $field = $this->getField();
        return array_values(array_filter($possibleValues, function ($value) use ($field, $threshold) {
            return (levenshtein($value, $field) <= $threshold);
        }));
    }
}