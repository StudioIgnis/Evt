<?php

namespace spec\StudioIgnis\Evt\Laravel;

use Illuminate\Events\Dispatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use StudioIgnis\Evt\Inflection\EventNameInflector;

class EventDispatcherSpec extends ObjectBehavior
{
    function let(Dispatcher $dispatcher, EventNameInflector $inflector)
    {
        $this->beConstructedWith($dispatcher, $inflector);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('StudioIgnis\Evt\Laravel\EventDispatcher');
    }

    function it_dispatches_events(Dispatcher $dispatcher, EventNameInflector $inflector)
    {
        $events = [
            new DummyEventOne,
            new DummyEventTwo,
        ];

        // Event 1
        $inflector->getName('spec\StudioIgnis\Evt\Laravel\DummyEventOne')
            ->willReturn('Event.One')->shouldBeCalled();
        $dispatcher->fire('Event.One', $events[0])->shouldBeCalled();

        // Event 2
        $inflector->getName('spec\StudioIgnis\Evt\Laravel\DummyEventTwo')
            ->willReturn('Event.Two')->shouldBeCalled();
        $dispatcher->fire('Event.Two', $events[1])->shouldBeCalled();

        $this->dispatch($events);
    }
}

class DummyEventOne {}
class DummyEventTwo {}
