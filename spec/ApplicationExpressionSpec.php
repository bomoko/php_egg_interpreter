<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WordExpression;

class ApplicationExpressionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(new WordExpression("do"));
        $this->shouldHaveType('ApplicationExpression');
    }

    function it_should_accept_arguments()
    {
      $this->beConstructedWith(new WordExpression("do"));
      $this->pushArg("first")->shouldReturn(true);
    }

    function it_should_return_its_operator()
    {
      $this->beConstructedWith(new WordExpression("do"));
      $this->operator()->shouldReturn("do");
    }

    function it_should_return_arguments_it_accepted_in_order()
    {
      $this->beConstructedWith(new WordExpression("do"));
      $this->pushArg("first")->shouldReturn(true);
      $this->pushArg("second")->shouldReturn(true);
      $this->popArg()->shouldReturn("second");
      $this->popArg()->shouldReturn("first");
    }

    function it_should_return_the_number_of_arguments_it_has()
    {
      $this->beConstructedWith(new WordExpression("do"));
      $this->pushArg("first")->shouldReturn(true);
      $this->pushArg("second")->shouldReturn(true);
      $this->numberArgs()->shouldReturn(2);
    }

    function it_should_allow_us_to_access_a_particular_argument_via_an_index()
    {
      $this->beConstructedWith(new WordExpression("do"));
      $this->pushArg("first")->shouldReturn(true);
      $this->pushArg("second")->shouldReturn(true);
      $this->getArg(0)->shouldReturn("first");
    }

    function it_should_throw_an_exception_if_we_attempt_to_access_an_argument_that_doesnt_exist()
    {
      $this->beConstructedWith(new WordExpression("do"));
      $this->pushArg("first")->shouldReturn(true);
      $this->pushArg("second")->shouldReturn(true);
      $this->shouldThrow("\Exception")->during("getArg",array(2));
    }

}
