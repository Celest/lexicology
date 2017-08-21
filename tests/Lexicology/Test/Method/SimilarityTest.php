<?php
/**
 * @author Jon West
 */

namespace Lexicology\Test\Method;

use Lexicology\Method\Similarity;
use PHPUnit\Framework\TestCase;

class SimilarityTest extends TestCase
{

    public function testRateSimilarity()
    {
        $similarity = new Similarity('string');
        $this->assertEquals(0, $similarity->rate('string', 'string'));
        $this->assertEquals(1, $similarity->rate('stri', 'string'));
        $this->assertEquals(-1, $similarity->rate('string', 'stri'));
        $this->assertEquals(0, $similarity->rate('s', 's'));
        $this->assertEquals(0, $similarity->rate('a', 'b'));
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
