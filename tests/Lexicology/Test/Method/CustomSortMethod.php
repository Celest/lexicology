<?php
/**
 * @author Jon West
 */

namespace Lexicology\Test\Method;

use Celestial\Lexicology\Method\AbstractMethod;
use Celestial\Lexicology\Method\Interfaces\SortInterface;
use Celestial\Lexicology\Method\Traits\SortTrait;

class CustomSortMethod extends AbstractMethod implements SortInterface
{
    use SortTrait;

    /**
     * Return a sort value if either an a or b match.
     *
     * @inheritdoc
     */
    public function sortPair($a, $b)
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
}