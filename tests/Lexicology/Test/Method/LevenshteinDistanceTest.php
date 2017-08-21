<?php
/**
 * @author Jon West
 */

namespace Lexicology\Test\Method;

use Lexicology\Method\LevenshteinDistance;
use PHPUnit\Framework\TestCase;

class LevenshteinDistanceTest extends TestCase
{
    public function testRateLevenshteinDistance()
    {
        $levenshtein = new LevenshteinDistance('string');
        $this->assertEquals(0, $levenshtein->rate('string', 'string'));
        $this->assertEquals(1, $levenshtein->rate('stri', 'string'));
        $this->assertEquals(-1, $levenshtein->rate('string', 'stri'));
        $this->assertEquals(0, $levenshtein->rate('s', 's'));
        $this->assertEquals(0, $levenshtein->rate('a', 'b'));
    }

    public function testFilterLevenshteinDistance()
    {
        $options = [
            "a",
            "s",
            "st",
            "stri",
            "str",
            "strin",
            "string"
        ];
        $expected = [
            "s",
            "st",
            "stri",
            "str",
            "strin",
            "string"
        ];
        $levenshtein = new LevenshteinDistance('string');
        $this->assertEquals($expected, $levenshtein->filter($options));
    }

    public function testFilterLevenshteinDistanceThreshold()
    {
        $options = [
            "a",
            "s",
            "st",
            "stri",
            "str",
            "strin",
            "string"
        ];
        $expected = [
            "stri",
            "strin",
            "string"
        ];
        $levenshtein = new LevenshteinDistance('string', 2);
        $this->assertEquals($expected, $levenshtein->filter($options));
    }

}
