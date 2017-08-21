<?php
/**
 * @author Jon West
 */

namespace Lexicology\Method;


use Lexicology\Method\Traits\ThresholdTrait;

class LevenshteinDistance extends AbstractMethod implements MethodInterface
{
    use ThresholdTrait;

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
    public function rate(string $a, string $b):? int
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
    public function filter(array $possibleValues): array
    {
        $threshold = $this->getThreshold();
        $field = $this->getField();
        return array_values(array_filter($possibleValues, function ($value) use ($field, $threshold) {
            return (levenshtein($value, $field) <= $threshold);
        }));
    }
}