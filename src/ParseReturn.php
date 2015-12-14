<?php

/**
 * This is used as a transfer object from parseExpression to the rest of the App
 */
class ParseReturn
{
  private $expression = null;
  private $rest = null;

  function __construct($expression, $rest = null)
  {
    $this->expression = $expression;
    $this->rest = $rest;
  }

  function getExpression()
  {
    return $this->expression;
  }

  function getRest()
  {
    return $this->rest;
  }
}
