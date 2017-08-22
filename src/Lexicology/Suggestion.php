<?php
/**
 * @author Jon West
 */

namespace Celestial\Lexicology;

use Celestial\Lexicology\Exception\EmptyHaystackException;
use Celestial\Lexicology\Exception\NoSuggestionException;
use Celestial\Lexicology\Method\Interfaces\FilterInterface;
use Celestial\Lexicology\Method\Interfaces\SortInterface;
use Celestial\Lexicology\Method\PregGrep;

class Suggestion
{
    /**
     * @param $needle
     * @param $haystack
     * @param string|null $className
     * @return mixed
     * @throws \Exception
     */
    public function getSuggestions($needle, $haystack, $className = null)
    {
        if (is_null($className)) {
            $className = PregGrep::class;
        }
        if (is_array($haystack) && count($haystack) > 1) {
            /** @var FilterInterface $suggestedClass */
            $suggestedClass = new $className($needle);
            if (method_exists($className, 'filter')) {
                $possibleHaystack = $suggestedClass->filter($haystack);
            } else {
                $possibleHaystack = $haystack;
            }
            if (method_exists($className, 'sort')) {
                /** @var SortInterface $suggestedClass */
                return $suggestedClass->sort($possibleHaystack);
            }
            return $possibleHaystack;
        } else {
            throw new EmptyHaystackException();
        }
    }

    /**
     * @param string $needle
     * @param array $haystack
     * @param string|null $className
     * @param string|null $overrideExceptionValue
     * @return array
     * @throws NoSuggestionException
     */
    public function getSingleSuggestion($needle, $haystack, $className = null, $overrideExceptionValue = null)
    {
        $suggestions = $this->getSuggestions($needle, $haystack, $className);
        if (count($suggestions) === 0) {
            if (!is_null($overrideExceptionValue)) {
                return [$overrideExceptionValue];
            } else {
                throw new NoSuggestionException("No suggestion for $needle");
            }
        } else {
            return [$suggestions[0]];
        }
    }
}
