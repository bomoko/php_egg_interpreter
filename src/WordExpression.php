<?php

class WordExpression implements Expression
{
  private $name;

  function __construct($name) {
    $this->name = $name;
  }

    public function name()
    {
        return $this->name;
    }

    public function toString()
    {
      return $this->name();
    }
}
