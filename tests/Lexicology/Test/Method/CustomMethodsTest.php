<?php
/**
 * @author Jon West
 */

namespace Lexicology\Test\Method;

use Celestial\Lexicology\Suggestion;
use PHPUnit\Framework\TestCase;

class CustomMethodsTest extends TestCase
{
    public function testCustomMethod()
    {
        $suggestionOptions = [
            'string',
            'strings',
            'new string',
            'value',
            'variable'
        ];

        $expectedSuggestions = [
            'new string',
            'strings',
            'variable',
            'string'
        ];

        $suggestion = new Suggestion();
        $suggestions = $suggestion->getSuggestions('string', $suggestionOptions, CustomMethod::class);

        $this->assertEquals($expectedSuggestions, $suggestions);
    }

    public function testCustomSortMethod()
    {
        $suggestionOptions = [
            'string',
            'strings',
            'new string',
            'value',
            'variable'
        ];

        $expectedSuggestions = [
            'new string',
            'strings',
            'value',
            'variable',
            'string'
        ];

        $suggestion = new Suggestion();
        $suggestions = $suggestion->getSuggestions('string', $suggestionOptions, CustomSortMethod::class);

        $this->assertEquals($expectedSuggestions, $suggestions);
    }

    public function testCustomFilterMethod()
    {
        $suggestionOptions = [
            'string',
            'strings',
            'new string',
            'value',
            'variable'
        ];

        $expectedSuggestions = [
            'string',
            'strings',
            'new string',
            'variable'
        ];

        $suggestion = new Suggestion();
        $suggestions = $suggestion->getSuggestions('string', $suggestionOptions, CustomFilterMethod::class);

        $this->assertEquals($expectedSuggestions, $suggestions);
    }
}
