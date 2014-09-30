<?php namespace StudioIgnis\Evt\Traits;

trait HasDomainEvents
{
    /**
     * @var array
     */
    protected $pendingEvents = [];

    /**
     * Raise a new event
     *
     * @param $event
     */
    public function raise($event)
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
