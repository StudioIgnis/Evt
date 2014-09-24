<?php

namespace spec\StudioIgnis\Evt\Traits;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use StudioIgnis\Evt\Traits\EventGenerator;

class EventGeneratorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('spec\StudioIgnis\Evt\Traits\DummyEntity');
    }

    function it_raises_and_releases_events()
    {
        $dummyEvent = new DummyEvent;

        $this->raise($dummyEvent);

        $this->releaseEvents()->shouldReturn([$dummyEvent]);
    }
}

class DummyEntity
{
    use EventGenerator;
}

class DummyEvent {}
