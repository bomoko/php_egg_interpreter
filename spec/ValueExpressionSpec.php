<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ValueExpressionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('some value');
        $this->shouldHaveType('ValueExpression');
    }

    function it_should_accept_a_value_when_constructed_and_return_it_when_value_called()
    {
      $this->beConstructedWith('some value');
      $this->value()->shouldReturn('some value');
    }


}
