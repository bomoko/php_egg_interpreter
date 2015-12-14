<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WordExpressionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('theName');
        $this->shouldHaveType('WordExpression');
    }

    function it_should_return_the_name_it_was_constructed_with()
    {
      $this->beConstructedWith('theName');
      $this->name()->shouldReturn('theName');
    }
}
