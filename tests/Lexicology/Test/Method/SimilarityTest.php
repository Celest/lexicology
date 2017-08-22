<?php
/**
 * @author Jon West
 */

namespace Lexicology\Test\Method;

use Celestial\Lexicology\Method\Similarity;
use PHPUnit\Framework\TestCase;

class SimilarityTest extends TestCase
{

    public function testSortPairSimilarity()
    {
        $similarity = new Similarity('string');
        $this->assertEquals(0, $similarity->sortPair('string', 'string'));
        $this->assertEquals(1, $similarity->sortPair('stri', 'string'));
        $this->assertEquals(-1, $similarity->sortPair('string', 'stri'));
        $this->assertEquals(0, $similarity->sortPair('s', 's'));
        $this->assertEquals(0, $similarity->sortPair('a', 'b'));
    }

    public function testFilterSimilarity()
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
        $similarity = new Similarity('string');
        $this->assertEquals($expected, $similarity->filter($options));
    }
}
