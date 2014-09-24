<?php

namespace spec\StudioIgnis\Evt\Inflection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DotterInflectorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('StudioIgnis\Evt\Inflection\DotterInflector');
    }

    function it_inflects_the_event_name_from_a_class_name()
    {
        $this->getName('Foo\Bar\Baz')->shouldReturn('Foo.Bar.Baz');
    }
}
