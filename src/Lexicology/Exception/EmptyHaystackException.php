<?php
/**
 * @author Jon West
 */

namespace Celestial\Lexicology\Exception;

class EmptyHaystackException extends \Exception
{
    protected $message = 'Suggestion method requires $haystack to be an array with more than one value.';
}