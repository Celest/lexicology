<?php
/**
 * @author Jon West
 */

namespace Lexicology\Test;

use Lexicology\Suggestion;
use Lexicology\Test\Method\CustomMethod;
use PHPUnit\Framework\TestCase;

class SuggestionTest extends TestCase
{
    /**
     * @var Suggestion
     */
    public $comparison;

    public function setup()
    {
        $this->comparison = new Suggestion();
    }

    public function testSuggestFields()
    {
        $options = [
            "a",
            "s",
            "st",
            "stri",
            "str",
            "strin",
            "string",
            "some random string"
        ];
        $this->assertEquals(['string', 'some random string'],
            $this->comparison->suggestFields('string', $options)
        );
    }

    public function testSuggestFieldExample()
    {
        $suggestionOptions = [
            'string',
            'new string',
            'value',
            'variable'
        ];

        $expectedSuggestions = [
            'string',
            'new string'
        ];

        $suggestion = new Suggestion();
        $suggestions = $suggestion->suggestFields('string', $suggestionOptions);

        $this->assertEquals($expectedSuggestions, $suggestions);
    }

    public function testCustomSuggestFieldExample()
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
        $suggestions = $suggestion->suggestFields('string', $suggestionOptions, CustomMethod::class);

        $this->assertEquals($expectedSuggestions, $suggestions);
    }
}
