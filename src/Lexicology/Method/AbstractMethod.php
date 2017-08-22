<?php
/**
 * @author Jon West
 */

namespace Celestial\Lexicology\Method;

/**
 * Class AbstractMethod
 * @package Lexicology\Method
 */
abstract class AbstractMethod
{
    /**
     * @var
     */
    protected $field;

    /**
     * AbstractMethod constructor.
     * @param $field
     */
    public function __construct($field)
    {
        $this->setField($field);
    }

    /**
     * @param string $field
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }
}