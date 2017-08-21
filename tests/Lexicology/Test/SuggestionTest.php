<?php
/**
 * @author Jon West
 */

namespace Lexicology\Test;

use Lexicology\Suggestion;
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
}
