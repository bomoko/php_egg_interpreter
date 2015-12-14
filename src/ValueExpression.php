<?php

/**
 * This represents expressions for our AST
 */
class ValueExpression implements Expression
{
    protected $value = null;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function toString()
    {
      return $this->value();
    }

    public function value()
    {
        return $this->value;
    }


}
