<?php
/**
 * @author Jon West
 */

namespace Lexicology;

use Lexicology\Method\Interfaces\FilterInterface;
use Lexicology\Method\PregGrep;

class Suggestion
{
    /**
     * @param $needle
     * @param $haystack
     * @param string|null $method
     * @return mixed
     * @throws \Exception
     */
    public function suggestFields($needle, $haystack, $method = null)
    {
        if($method === null) {
            $method = PregGrep::class;
        }
        if (count($haystack) > 1) {
            /** @var FilterInterface $suggestMethod */
            $suggestMethod = new $method($needle);
            return $suggestMethod->filter($haystack);
        } else {
            throw new \Exception(
                'Comparison suggestFields method requires $haystack to be an array with more than one value.');
        }
    }
}
