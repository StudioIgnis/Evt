<?php

namespace spec\StudioIgnis\Evt\Traits;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use StudioIgnis\Evt\Event;
use StudioIgnis\Evt\Traits\HasDomainEvents;

class HasDomainEventsSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('spec\StudioIgnis\Evt\Traits\DummyEntity');
    }

    function it_raises_and_releases_events(Event $event)
    {
        $this->raise($event);

        $this->releaseEvents()->shouldReturn([$event]);
    }
}

class DummyEntity
{
    use HasDomainEvents;
}
