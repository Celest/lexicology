<?php
/**
 * @author Jon West
 */

namespace Lexicology\Test\Method;

use Celestial\Lexicology\Method\PregGrep;
use PHPUnit\Framework\TestCase;

class PregGrepTest extends TestCase
{
    public function testSortPairSimilarity()
    {
        $similarity = new PregGrep('string');
        $this->assertEquals(0, $similarity->sortPair('string', 'string'));
        $this->assertEquals(-1, $similarity->sortPair('stri', 'string'));
        $this->assertEquals(1, $similarity->sortPair('string', 'stri'));
        $this->assertNull($similarity->sortPair('s', 's'));
        $this->assertNull($similarity->sortPair('a', 'b'));
    }

    public function testPregMatchFields()
    {
        $options = [
            "a",
            "s",
            "st",
            "stri",
            "str",
            "strin",
            "string",
            "String",
            "stringent",
            "streams"
        ];

        $pregGrep = new PregGrep('string');
        $this->assertEquals(['string', 'String', 'stringent'],
            $pregGrep->filter($options)
        );

        $options = [
            "string",
            "string with words",
            "string_with_words",
        ];
        $this->assertEquals(['string', 'string with words', 'string_with_words'],
            $pregGrep->filter($options)
        );

        $pregGrep = new PregGrep('with');
        $this->assertEquals(['string with words', 'string_with_words'],
            $pregGrep->filter($options)
        );
    }
}
