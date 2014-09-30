<?php

namespace spec\StudioIgnis\Evt;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use StudioIgnis\Evt\Event;
use StudioIgnis\Evt\EventListener;
use StudioIgnis\Evt\Support\Container;

class EventDispatcherSpec extends ObjectBehavior
{
    function let(Container $container)
    {
        $this->beConstructedWith($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('StudioIgnis\Evt\EventDispatcher');
    }

    function it_dispatches_events_to_registered_listeners(
        EventListener $listener,
        Event $event
    )
    {
        $this->addListener('foo', $listener);

        $event->getName()->willReturn('foo')->shouldBeCalled();

        $this->dispatch([$event]);
    }

    function it_dispatches_events_to_registered_lazy_listeners(
        Container $container,
        Event $event
    )
    {
        $listenerName = 'FooEventListener';

        $this->addListener('foo', $listenerName);

        // Stub & mock container
        $container->resolve($listenerName)->willReturn(new FooEventListener)->shouldBeCalled();
        // Stub event
        $event->getName()->willReturn('foo');

        // Listeners are instantiated on dispatch
        $this->dispatch([$event]);
    }
}

class FooEventListener implements EventListener
{
    public function handle($event) {}
}
