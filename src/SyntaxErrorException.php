<?php

/**
 *
 */
class SyntaxErrorException extends Exception
{

  function __construct($string)
  {
    $this->message = $string;
  }
}
