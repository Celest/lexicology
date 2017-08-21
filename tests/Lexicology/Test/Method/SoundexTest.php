<?php
/**
 * @author Jon West
 */

namespace Lexicology\Test\Method;

use Lexicology\Method\Soundex;
use PHPUnit\Framework\TestCase;

class SoundexTest extends TestCase
{
    public function testRateSoundex()
    {
        $soundex = new Soundex('string');
        $this->assertEquals(0, $soundex->rate('string', 'string'));
        $this->assertEquals(1, $soundex->rate('stri', 'string'));
        $this->assertEquals(-1, $soundex->rate('string', 'stri'));
        $this->assertEquals(0, $soundex->rate('s', 's'));

        $this->assertNull($soundex->rate('a', 's'));
        $this->assertNull($soundex->rate('a', 'b'));
        $this->assertNull($soundex->rate('a', 'c'));
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
