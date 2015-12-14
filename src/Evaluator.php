<?php

use \Environment;

class Evaluator
{
    public function evaluate($expression,Environment $environment)
    {
        if($expression instanceof ValueExpression)
        {
          if(is_numeric($expression->value())) {
            return floatval($expression->value());
          } else {
            return $expression->value();
          }
        } elseif ($expression instanceof WordExpression) {
          if(!$environment->exists($expression->name()))
          {
            throw new Exception("Variable '" . $expression->name() . "' does not exist");
          }
          return $environment->get($expression->name());
        } elseif ($expression instanceof ApplicationExpression) {

          //Special Forms follow ...
          switch($expression->operator()) {
            case('if') :
              if($expression->numberArgs() != 3){
                throw new Exception('Wrong number of Arguments sent to if');
              }
              if($this->evaluate($expression->getArg(0),$environment) == true) {
                return $this->evaluate($expression->getArg(1),$environment);
              } else {

                return $this->evaluate($expression->getArg(2),$environment);
              }
            break;
            case('do'):
              $ret = null;
              for($i = 0; $i < $expression->numberArgs(); $i++)
              {
                $ret = $this->evaluate($expression->getArg($i),$environment);
              }
              return $ret;
            break;
            case('print'):
              if($expression->numberArgs() != 1){
                throw new Exception('Wrong number of Arguments sent to print');
              }
              $printVal = $this->evaluate($expression->getArg(0),$environment);
              print($printVal."\n");
              return $printVal;
            break;
            case('while'):
              // print("Num args ". $expression->numberArgs() . " \n\n");
              if($expression->numberArgs() != 2){
                throw new Exception('Wrong number of Arguments sent to while');
              }
              // print($this->evaluate($expression->getArg(0),$environment)."*****\n\n\n\n\n");
              while($this->evaluate($expression->getArg(0),$environment)) {
                $this->evaluate($expression->getArg(1),$environment);
              }
              return null;
            break;
            case('define'):
              if($expression->numberArgs() != 2 || !($expression->getArg(0) instanceof WordExpression )) {
                throw new Exception("Bad use of define");
              }
              $key = $expression->getArg(0)->name();//$this->evaluate($expression->getArg(0),$environment);
              $value = $this->evaluate($expression->getArg(1),$environment);
              $environment->set($key,$value);
              return $environment->get($key);
            break;
            case('fun'):
              if($expression->numberArgs() == 0) {
                throw new Exception("Functions need at least a body argument");
              }

              $argNames = [];
              for($i = 0; $i < $expression->numberArgs() - 1; $i++)
              {
                $argNames[] = $expression->getArg($i)->name();
              }
              $body = $expression->getArg($expression->numberArgs() - 1);
              return function() use ($argNames,$body,$environment) {
                //check we have the right number of arguments ...
                $passedArgs = func_get_args();
                // print("RUNNING FUNC with args " . print_r($passedArgs,true) . " and argnames " .print_r($argNames,true) . "\n\n");
                if(count($passedArgs) != count($argNames)) {
                  throw new Exception('Function called with wrong number of arguments');
                }

                //here we set up our local environment
                $localEnv = $environment->cloneEnvironment();

                foreach ($passedArgs as $key => $value) {
                  // print("-->".$key."<--");
                  $localEnv->set($argNames[$key],$value);
                }
                $innerEvaluator = new Evaluator;
                return $innerEvaluator->evaluate($body,$localEnv);
              };

            break;
            default:
              $mathLogic = ["+", "-", "*", "/", "==", "<", ">","<=",">="];
              if(in_array($expression->operator(),$mathLogic)) {
                $code = 'return ' . $this->evaluate($expression->getArg(0),$environment) . ' ' . $expression->operator() . ' ' . $this->evaluate($expression->getArg(1),$environment) . ";";
                // print("{$code}\n\n");
                return eval($code);
              }

              //see if there's a matching function in the environment
              if($environment->exists($expression->operator())) {
                $operation = $environment->get($expression->operator());
                if(is_callable($operation))
                {
                  //build up the argument array ...
                  $arguments = [];
                  // print_r($expression);
                  for($i = 0; $i < $expression->numberArgs(); $i++) {
                    $arguments[$i] = $this->evaluate($expression->getArg($i),$environment);
                  }
                  // print_r($arguments);
                  return call_user_func_array($operation,$arguments);
                }
              }
            break;
          }

          throw new Exception('Can\'t find any matching application to run');

        }
    }

    //private function
}
