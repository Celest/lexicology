<?php
/**
 * @author Jon West
 */

namespace Celestial\Lexicology\Method;

use Celestial\Lexicology\Method\Interfaces\FilterInterface;
use Celestial\Lexicology\Method\Interfaces\SortInterface;
use Celestial\Lexicology\Method\Traits\SortTrait;
use Celestial\Lexicology\Method\Traits\ThresholdTrait;

class Similarity extends AbstractMethod implements SortInterface, FilterInterface
{
    use ThresholdTrait;
    use SortTrait;

    /**
     * Similarity constructor.
     * @param string $field
     * @param float $threshold
     */
    public function __construct($field, $threshold = 0.9)
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
        similar_text($a, $this->getField(), $percentA);
        similar_text($b, $this->getField(), $percentB);
        if ($percentA === $percentB) {
            return 0;
        }
        return ($percentA < $percentB) ? 1 : -1;
    }

    /**
     * @param array $possibleValues
     * @return array
     */
    public function filter($possibleValues)
    {
        $field = $this->getField();
        $threshold = $this->getThreshold();
        return array_values(array_filter($possibleValues, function ($value) use ($field, $threshold) {
            return (similar_text($value, $field) >= $threshold);
        }));
    }

}