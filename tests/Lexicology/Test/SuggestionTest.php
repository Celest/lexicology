<?php
/**
 * @author Jon West
 */

namespace Lexicology\Test;

use Celestial\Lexicology\Method\LevenshteinDistance;
use Celestial\Lexicology\Method\PregGrep;
use Celestial\Lexicology\Method\Similarity;
use Celestial\Lexicology\Method\Soundex;
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

    public function testGetSuggestionStack()
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
            $this->subject->getSuggestions('string', $options, [PregGrep::class, Similarity::class, Soundex::class, LevenshteinDistance::class])
        );
    }

    public function testGetSuggestionsForArray()
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
        $expected = [
            'string' =>
                [
                    "string",
                    "some random string"
                ],
            "random" =>
                [
                    "some random string"
                ]
        ];
        $this->assertEquals($expected,
            $this->subject->getSuggestionsForArray(['string', 'random'], $options)
        );
    }

    public function testGetSuggestionsForArrayStack()
    {
        $options = [
            "a",
            "s",
            "st",
            "stri",
            "str",
            "strin",
            "string",
            "some random string",
            "random string",
            "randoms",
            "food",
            "foos",
            "foo"
        ];
        $expected = [
            "random" =>
                [
                    "randoms"
                ],
            'string' =>
                [
                    "string"
                ],
            "foo" =>
                [
                    "foo"
                ]
        ];
        $this->assertEquals($expected,
            $this->subject->getSuggestionsForArray(
                ['random', 'string', 'foo'],
                $options,
                [PregGrep::class, Similarity::class, Soundex::class, LevenshteinDistance::class]
            )
        );
    }

    public function testGetSuggestionsForArrayStackOverride()
    {
        $options = [
            "a",
            "s",
            "st",
            "stri",
            "str",
            "strin",
            "string",
            "some random string",
            "random string",
            "randoms"
        ];
        $expected = [
            "random" =>
                [
                    "randoms"
                ],
            'string' =>
                [
                    "string"
                ],
            "foo" =>
                [
                    "meta"
                ]
        ];
        $this->assertEquals($expected,
            $this->subject->getSuggestionsForArray(
                ['random', 'string', 'foo'],
                $options,
                [PregGrep::class, Similarity::class, Soundex::class, LevenshteinDistance::class],
                'meta'
            )
        );
    }

    public function testGetSuggestionsForArrayStackWithoutReduction() {

        $options = [
            "a",
            "s",
            "st",
            "stri",
            "str",
            "strin",
            "string",
            "strings",
            "string theory",
            "stringsa",
            "some random string",
            "random string",
            "randoms"
        ];
        $expected = [
            "random" =>
                [
                    "randoms"
                ],
            'string' =>
                [
                    "string",
                    "strings",
                    "stringsa"
                ],
            'strings' =>
                [
                    "strings",
                    "stringsa"
                ],
            "foo" =>
                [
                    "meta"
                ]
        ];
        $this->assertEquals($expected,
            $this->subject->getSuggestionsForArray(
                ['random', 'string', 'strings', 'foo'],
                $options,
                [PregGrep::class, Similarity::class, Soundex::class, LevenshteinDistance::class],
                'meta'
            )
        );
    }

    public function testGetSuggestionsForArrayStackReduction()
    {
        $options = [
            "a",
            "s",
            "st",
            "stri",
            "str",
            "strin",
            "string",
            "strings",
            "string theory",
            "stringsa",
            "some random string",
            "random string",
            "randoms"
        ];
        $expected = [
            "random" =>
                [
                    "randoms"
                ],
            'string' =>
                [
                    "string"
                ],
            'strings' =>
                [
                    "strings"
                ],
            "foo" =>
                [
                    "meta"
                ]
        ];
        $this->assertEquals($expected,
            $this->subject->getSuggestionsForArrayReduction(
                ['random', 'string', 'strings', 'foo'],
                $options,
                [PregGrep::class, Similarity::class, Soundex::class, LevenshteinDistance::class],
                'meta'
            )
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
