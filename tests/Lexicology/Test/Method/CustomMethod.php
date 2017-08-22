<?php
/**
 * @author Jon West
 */

namespace Lexicology\Test\Method;

use Lexicology\Method\AbstractMethod;
use Lexicology\Method\Interfaces\FilterInterface;
use Lexicology\Method\Interfaces\RateInterface;


class CustomMethod extends AbstractMethod implements RateInterface, FilterInterface
{
    /**
     * Return a sort value if either a or b match.
     *
     * @inheritdoc
     */
    public function rate($a, $b)
    {
        if ($a === $b) {
            return 0;
        } elseif ($a === $this->getField()) {
            return 1;
        } elseif ($b === $this->getField()) {
            return -1;
        }
        return null;
    }

    /**
     * Return a filter array of string that have more than 5 characters
     *
     * @inheritdoc
     */
    public function filter($possibleValues)
    {
        return array_values(array_filter($possibleValues, function ($value) {
            return (strlen($value) > 5);
        }));
    }

}