<?php
/**
 * @author Jon West
 */

namespace Lexicology\Method;

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
    public function setField(string $field)
    {
        $this->field = $field;
        return $this;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }
}