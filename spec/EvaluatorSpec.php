<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use \ValueExpression;
use \WordExpression;
use \ApplicationExpression;
use \Environment;
use \Parser;

class EvaluatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Evaluator');
    }

    function it_returns_a_value_when_passed_a_value_expression()
    {
      $this->evaluate(new ValueExpression(1),new Environment)->shouldReturn(1);
    }

    function it_checks_the_environment_contains_a_variable_with_word_as_key_if_a_word_expression_is_evaluated_by_itself()
    {
      $env = new Environment;
      $env->set('theword','thebird');
      $this->evaluate(new WordExpression('theword'),$env)->shouldReturn('thebird');
    }

    public function it_should_throw_an_exception_if_a_word_that_doesnt_exist_in_the_environment_is_evaluated()
    {
      $env = new Environment;
      $this->shouldThrow('\Exception')->during('evaluate',array(new WordExpression('theword'),$env));
    }

    //mathematical and logical operators

    public function it_should_return_true_when_arg1_is_greater_than_arg2()
    {
      $env = new Environment;
      $parser = new Parser;
      $expression = $parser->parseExpression('>(2,1)')->getExpression();
      $this->evaluate($expression,$env)->shouldReturn(true);
    }

    public function it_should_return_false_when_arg1_is_less_than_and_equal_to_arg2_is_false()
    {
      $env = new Environment;
      $parser = new Parser;
      $expression = $parser->parseExpression('<=(2,1)')->getExpression();
      $this->evaluate($expression,$env)->shouldReturn(false);
    }

    public function it_should_return_true_when_arg1_is_equal_to_arg2()
    {
      $env = new Environment;
      $parser = new Parser;
      $expression = $parser->parseExpression('==(2,2)')->getExpression();
      $this->evaluate($expression,$env)->shouldReturn(true);
    }

    public function it_should_return_two_when_adding_one_and_one()
    {
      $env = new Environment;
      $parser = new Parser;
      $expression = $parser->parseExpression('+(1,1)')->getExpression();
      $this->evaluate($expression,$env)->shouldReturn(2);
    }

    public function it_should_return_10_when_multiplying_5_and_2()
    {
      $env = new Environment;
      $parser = new Parser;
      $expression = $parser->parseExpression('*(5,2)')->getExpression();
      $this->evaluate($expression,$env)->shouldReturn(10);
    }

    //Special Forms tests ...


    public function it_should_allow_us_to_define_variables_in_the_environment()
    {
      $env = new Environment;
      $parser = new Parser;
      $expression = $parser->parseExpression('define(var1,"var1val")')->getExpression();
      // print_r($expression);
      $this->evaluate($expression,$env)->shouldReturn("var1val");

    }

    public function it_should_return_the_truepath_if_conditional_is_true()
    {
      $env = new Environment;
      $parser = new Parser;
      $expression = $parser->parseExpression('if(true,"isTrue","isFalse")')->getExpression();
      // print($expression->operator());
      $this->evaluate($expression,$env)->shouldReturn("isTrue");
    }


    public function it_should_return_the_falsepath_if_conditional_is_false()
    {
      $env = new Environment;
      $parser = new Parser;
      $expression = $parser->parseExpression('if(==(1,2),"isTrue","isFalse")')->getExpression();
      // print($expression->operator());
      $this->evaluate($expression,$env)->shouldReturn("isFalse");
    }

    public function it_should_update_the_environment_in_line_with_the_while_loop()
    {
      $env = new Environment;
      $env->set('a',10);
      $parser = new Parser;
      $expression = $parser->parseExpression('while(>(a,0),define(a,-(a,1)))')->getExpression();
      $this->evaluate($expression,$env)->shouldReturn(null);
    }

    public function it_should_execute_a_do_block_returning_the_value_of_the_last_argument()
    {
      $env = new Environment;
      $env->set('a',10);
      $parser = new Parser;
      $expression = $parser->parseExpression('do(while(>(a,0),define(a,-(a,1))),define(b,2),if(true,false,true))')->getExpression();
      $this->evaluate($expression,$env)->shouldReturn(false);
    }

    public function it_should_output_when_print_is_called()
    {
      $env = new Environment;
      $env->set('a',10);
      $parser = new Parser;
      $expression = $parser->parseExpression('print(a)')->getExpression();
    }

    public function it_should_allow_the_definition_of_a_function()
    {
      $env = new Environment;
      // $env->set('a',function($a){ return $a;});
      $parser = new Parser;
      $expression = $parser->parseExpression('do(define(inc,fun(a,+(a,1))),inc(5))')->getExpression();
       $this->evaluate($expression,$env)->shouldReturn(6);
    }


}
