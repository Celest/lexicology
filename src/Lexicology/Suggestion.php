<?php
/**
 * @author Jon West
 */

namespace Lexicology;

use Lexicology\Method\MethodInterface;
use Lexicology\Method\PregGrep;

class Suggestion
{
    public function suggestFields($field, $haystack, MethodInterface $method = null)
    {
        if($method === null) {
            $method = PregGrep::class;
        }
        if (count($haystack) > 1) {
            /** @var MethodInterface $suggestMethod */
            $suggestMethod = new $method($field);
            return $suggestMethod->filter($haystack);
        } else {
            throw new \Exception(
                'Comparison suggestFields method requires $haystack to be an array with more than one value.');
        }
    }
}
