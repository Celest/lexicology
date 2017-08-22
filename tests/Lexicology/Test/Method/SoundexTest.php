<?php
/**
 * @author Jon West
 */

namespace Lexicology\Test\Method;

use Celestial\Lexicology\Method\Soundex;
use PHPUnit\Framework\TestCase;

class SoundexTest extends TestCase
{
    public function testSortPairSoundex()
    {
        $soundex = new Soundex('string');
        $this->assertEquals(0, $soundex->sortPair('string', 'string'));
        $this->assertEquals(1, $soundex->sortPair('stri', 'string'));
        $this->assertEquals(-1, $soundex->sortPair('string', 'stri'));
        $this->assertEquals(0, $soundex->sortPair('s', 's'));

        $this->assertNull($soundex->sortPair('a', 's'));
        $this->assertNull($soundex->sortPair('a', 'b'));
        $this->assertNull($soundex->sortPair('a', 'c'));
    }

    public function testFilterSoundex()
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
            "strin",
            "string"
        ];

        $soundex = new Soundex('string');
        $this->assertEquals($expected, $soundex->filter($options));
    }
}
