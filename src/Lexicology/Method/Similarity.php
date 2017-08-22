<?php
/**
 * @author Jon West
 */

namespace Lexicology\Method;

use Lexicology\Method\Interfaces\FilterInterface;
use Lexicology\Method\Interfaces\RateInterface;
use Lexicology\Method\Traits\ThresholdTrait;

class Similarity extends AbstractMethod implements RateInterface, FilterInterface
{
    use ThresholdTrait;

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
    public function rate($a, $b)
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