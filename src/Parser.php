<?php

class Parser
{
    public function parseExpression($prog)
    {
        $prog = ltrim($prog);
        //here we do the main work of matching values and words ...
        $matches = [];
        $returnExpression = null;
        if(preg_match('/^"([^"]*)"/',$prog,$matches)) {
          $returnExpression = new ParseReturn(new ValueExpression($matches[1]),substr($prog,strlen($matches[0])));
        } elseif(preg_match('/^\d+\b/',$prog,$matches)) {
          $returnExpression = new ParseReturn(new ValueExpression($matches[0]),substr($prog,strlen($matches[0])));
        } elseif(preg_match('/^[^\s(),"]+/',$prog,$matches)) {
          $returnExpression = new ParseReturn(new WordExpression($matches[0]),substr($prog,strlen($matches[0])));
        }
        return $this->parseApplication($returnExpression);
    }

  private function parseApplication(ParseReturn $ret)
  {

    //unwind the transfer object ...
    $expression = $ret->getExpression();
    $program = ltrim($ret->getRest());

    if(strlen($program) == 0 || $program[0] != '(') { //we test to see if this is an application or not - if it's not, just return its ass ...
      return $ret;
    }

    $program = ltrim(substr($program,1)); //strip opening brace ...
    $application = new ApplicationExpression($expression);
    while($program[0] != ')')
    {
      $arg = $this->parseExpression($program);
      // print_r($arg);
      $application->pushArg($arg->getExpression());
      $program = ltrim($arg->getRest());
      if($program[0] == ",") {
          $program = ltrim(substr($program,1));
      } elseif($program[0] != ")") {
        throw new SyntaxErrorException("No Closing Brace");
      }
    }
    // print("***{$program}***\n");
    // print_r($application);
    return new ParseReturn($application,substr($program,1));
  }
}
