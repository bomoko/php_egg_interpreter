<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EnvironmentSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Environment');
    }

    function it_should_accept_a_new_assignment()
    {
      $this->set('name','value')->shouldReturn(true);
    }

    function it_should_return_an_assignments_value_given_a_key()
    {
      $this->set('first','firstval')->shouldReturn(true);
      $this->get('first')->shouldReturn('firstval');
    }

    function it_should_have_boolean_vars_defined_by_default()
    {
      $this->get('true')->shouldReturn(true);
      $this->get('false')->shouldReturn(false);
    }

    function it_should_tell_us_if_a_variable_doesnt_exist()
    {
      $this->exists('somekey')->shouldReturn(false);
    }

    function it_should_tell_us_if_a_variable_does_exist()
    {
      $this->set('somekey','theval')->shouldReturn(true);
      $this->exists('somekey')->shouldReturn(true);
    }

    function it_should_return_null_if_an_assignment_isnt_in_the_environment()
    {
      $this->get('doesntexist')->shouldReturn(null);
    }

    function it_should_return_a_deep_copy_when_cloned()
    {
      $this->set('testArg','val')->shouldReturn(true);
      $this->cloneEnvironment()->shouldBeAnInstanceOf("Environment");
      $this->cloneEnvironment()->get('testArg')->shouldReturn("val");
    }

}
