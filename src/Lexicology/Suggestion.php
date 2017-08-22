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
     * @param string|array|null $className
     * @return mixed
     * @throws \Exception
     * @throws EmptyHaystackException
     */
    public function getSuggestions($needle, $haystack, $className = null)
    {
        if (is_null($className)) {
            $className = PregGrep::class;
        }
        if (is_array($haystack) && count($haystack) > 1) {
            if (is_array($className)) {
                $suggestedStack = $haystack;
                foreach ($className as $suggestedClassName) {
                    $suggestedStack = $this->callMethodStack($needle, $suggestedStack, $suggestedClassName);
                }
            } else {
                $suggestedStack = $this->callMethodStack($needle, $haystack, $className);
            }
            return $suggestedStack;
        } else {
            throw new EmptyHaystackException();
        }
    }

    /**
     * @param string $needle
     * @param array $haystack
     * @param string|array|null $className
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

    /**
     * @param array $needleStack
     * @param array $haystack
     * @param string|array|null $className
     * @param string|null $overrideExceptionValue
     * @return array
     * @throws NoSuggestionException
     * @throws EmptyHaystackException
     */
    public function getSuggestionsForArray($needleStack, $haystack, $className = null, $overrideExceptionValue = null)
    {
        if (is_null($className)) {
            $className = PregGrep::class;
        }
        if (is_array($needleStack)) {
            $suggestionStack = [];
            foreach ($needleStack as $needle) {
                $suggestionStack[$needle] = $this->getSuggestions($needle, $haystack, $className);
            }
            $finalStack = [];
            array_map(function ($key, $value) use ($overrideExceptionValue, &$finalStack) {
                if (count($value) === 0) {
                    if (!is_null($overrideExceptionValue)) {
                        $finalStack[$key] = [$overrideExceptionValue];
                    } else {
                        throw new NoSuggestionException("No suggestion for $key");
                    }
                } else {
                    $finalStack[$key] = $value;
                }
            }, array_keys($suggestionStack), $suggestionStack);
            return $finalStack;
        }
    }

    /**
     * @param array $needleStack
     * @param array $haystack
     * @param string|array|null $className
     * @param string|null $overrideExceptionValue
     * @return array
     * @throws NoSuggestionException
     * @throws EmptyHaystackException
     */
    public function getSuggestionsForArrayReduction($needleStack, $haystack, $className = null, $overrideExceptionValue = null)
    {
        $stack = $this->getSuggestionsForArray($needleStack, $haystack, $className, $overrideExceptionValue);
        $savedValues = [];

        $finalStack = [];
        foreach ($stack as $item => $value) {
            if (count($value) === 1 && current($value) !== $overrideExceptionValue && !in_array(current($value), $savedValues)) {
                $finalStack[$item] = [current($value)];
                $savedValues[] = [current($value)];
            } elseif (count($value) > 1 && !in_array(current($value), $savedValues)) {
                $finalStack[$item] = [current($value)];
                $savedValues[] = [current($value)];
            } else {
                $finalStack[$item] = [$overrideExceptionValue];
            }
        }
        return $finalStack;
    }

    /**
     * @param $needle
     * @param $haystack
     * @param $className
     * @return array
     */
    private function callMethodStack($needle, $haystack, $className)
    {
        $suggestedStack = [];
        /** @var FilterInterface $suggestedClass */
        $suggestedClass = new $className($needle);
        if (method_exists($className, 'filter')) {
            $suggestedStack = $suggestedClass->filter($haystack);
        } else {
            $suggestedStack = $haystack;
        }
        if (method_exists($className, 'sort')) {
            /** @var SortInterface $suggestedClass */
            $suggestedStack = $suggestedClass->sort($suggestedStack);
        }
        return $suggestedStack;
    }
}
