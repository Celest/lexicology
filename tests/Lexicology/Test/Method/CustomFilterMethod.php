<?php
/**
 * @author Jon West
 */

namespace Lexicology\Test\Method;

use Celestial\Lexicology\Method\AbstractMethod;
use Celestial\Lexicology\Method\Interfaces\FilterInterface;


class CustomFilterMethod extends AbstractMethod implements FilterInterface
{

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