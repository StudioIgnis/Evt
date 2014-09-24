<?php

namespace spec\StudioIgnis\Evt\Laravel;

use Illuminate\Container\Container;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use StudioIgnis\Evt\EventListener;

class EventListenerSpec extends ObjectBehavior
{
    function let(Container $app)
    {
        $this->beConstructedWith($app, 'Foo\Bar');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('StudioIgnis\Evt\Laravel\EventListener');
    }

    function it_handles_an_event(Container $app, EventListener $listener)
    {
        $app->make('Foo\Bar\DummyEventListener')
            ->willReturn($listener)
            ->shouldBeCalled();

        $dummyEvent = new DummyEvent();

        $listener->handle($dummyEvent)
            ->shouldBeCalled();

        $this->handle($dummyEvent);
    }
}

class DummyEvent {}
