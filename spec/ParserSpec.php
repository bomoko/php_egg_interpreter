<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Parser');
    }

    // function it_should_return_null_when_passed_nothing_to_parse()
    // {
    //   $this->parseExpression(null)->shouldReturn(null);
    // }

    // commenting this out because it's actually _not_ the next simplest test ...
    // only AFTER covering all valid forms will we be able to identify syntactial errors
    // function it_should_throw_an_exception_when_passed_ill_formed_string()
    // {
    //   $this->shouldThrow('\SyntaxErrorException')->during('parseExpression',array("whahanothingIsNotBlah"));
    // }

    function it_should_return_a_ParseReturn_object_when_complete()
    {
      $this->parseExpression("1")->shouldBeAnInstanceOf('ParseReturn');
    }

    function it_should_return_an_Expression_when_passed_valid_text_expression()
    {
      $this->parseExpression("1")->getExpression()->shouldBeAnInstanceOf('Expression');
    }

    function it_should_return_a_ValueExpression_when_passed_a_string()
    {
      $this->parseExpression('"text value"')->getExpression()->shouldBeAnInstanceOf('ValueExpression');
    }

    function it_should_return_a_ValueExpression_when_passed_an_integer()
    {
      $this->parseExpression('1')->getExpression()->shouldBeAnInstanceOf('ValueExpression');
    }

    function it_should_return_a_WordExpression_when_passed_an_unescaped_string()
    {
      $this->parseExpression('aWord')->getExpression()->shouldBeAnInstanceOf('WordExpression');
    }

    function it_should_return_another_WordExpression_when_passed_an_unescaped_string()
    {
      $this->parseExpression('aWord anotherword')->getExpression()->shouldBeAnInstanceOf('WordExpression');
    }

    function it_should_return_ApplyExpression_when_passed_an_application()
    {
      $this->parseExpression('do(blah(123))')->getExpression()->shouldBeAnInstanceOf('ApplicationExpression');
    }

    function it_should_return_ApplyExpression_when_passed_an_application_that_contains_commas()
    {
      $this->parseExpression('do(blah(123,456))')->getExpression()->shouldBeAnInstanceOf('ApplicationExpression');
    }

    function it_should_return_ApplyExpression_when_passed_an_application_that_contains_commas_and_spaces()
    {
      $this->parseExpression(' do ( blah ( 123, 456 ) ) ')->getExpression()->shouldBeAnInstanceOf('ApplicationExpression');
    }

    function it_should_return_an_ApplyExpression_with_two_arguments()
    {
      $this->parseExpression('while(>(a,0),define(a,-(a,1)))')->getExpression()->numberArgs()->shouldReturn(2);
    }

    // function it_should_return_an_Expression_of_value_type_when_passed_a_text_expression()
    // {
    //   $this->parseExpression('"sometext"')->getType()->shouldBeEqualTo(\Expression::TYPE_VALUE);
    // }

}
