<?php namespace StudioIgnis\Evt\Traits;

use StudioIgnis\Evt\Event;

trait HasDomainEvents
{
    /**
     * @var array
     */
    protected $pendingEvents = [];

    /**
     * Raise a new event
     *
     * @param Event $event
     */
    public function raise(Event $event)
    {
        $this->pendingEvents[] = $event;
    }

    /**
     * Release pending events
     *
     * @return array
     */
    public function releaseEvents()
    {
        $pendingEvents = $this->pendingEvents;

        $this->pendingEvents = [];

        return $pendingEvents;
    }
}
