<?php

class ApplicationExpression implements Expression
{
    protected $operator;
    protected $args = [];

    public function __construct(Expression $operator)
    {
        $this->operator = $operator;
    }

    public function toString()
    {
      if($this->operator instanceof ApplicationExpression) {
        return null;
      } else {
        return $this->operator->toString();
      }
    }

    public function pushArg($val)
    {
        array_push($this->args,$val);
        return true;
    }

    public function popArg()
    {
        return array_pop($this->args);
    }

    public function operator()
    {
        return $this->operator->toString();
    }

    public function numberArgs()
    {
        return count($this->args);
    }

    public function getArg($index)
    {
        return $this->args[$index];
    }
}
