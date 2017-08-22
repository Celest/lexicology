<?php
/**
 * @author Jon West
 */

namespace Lexicology\Test;

use Celestial\Lexicology\Suggestion;
use PHPUnit\Framework\TestCase;

class SuggestionTest extends TestCase
{
    /**
     * @var Suggestion
     */
    public $subject;

    public function setup()
    {
        $this->subject = new Suggestion();
    }

    public function testGetSuggestions()
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
            $this->subject->getSuggestions('string', $options)
        );
    }

    public function testGetSingleSuggestion()
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
        $this->assertEquals(['string'],
            $this->subject->getSingleSuggestion('string', $options)
        );
    }

    public function testGetSingleOverrideSuggestion()
    {
        $options = [
            "a",
            "s"
        ];
        $this->assertEquals(['meta'],
            $this->subject->getSingleSuggestion('string', $options, null, 'meta')
        );
    }

    /**
     * @expectedException Celestial\Lexicology\Exception\NoSuggestionException
     */
    public function testGetSingleExceptionSuggestion()
    {
        $options = [
            "a",
            "b"
        ];
        $this->subject->getSingleSuggestion('string', $options);
    }

    /**
     * @expectedException Celestial\Lexicology\Exception\EmptyHaystackException
     */
    public function testGetExceptionSuggestion()
    {
        $options = [
            "a"
        ];
        $this->subject->getSuggestions('string', $options);
    }

    public function testGetSuggestionsExample()
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
        $suggestions = $suggestion->getSuggestions('string', $suggestionOptions);

        $this->assertEquals($expectedSuggestions, $suggestions);
    }
}
