<?php namespace StudioIgnis\Evt\Traits;

/**
 * EventName Trait
 *
 * Fulfills the Event contract with a default naming strategy
 *
 * @see \StudioIgnis\Evt\Event
 */
trait EventName
{
    /**
     * Get the event name as the class short name
     *
     * @return string
     * @see \StudioIgnis\Evt\Event
     */
    public function getEventName()
    {
        return (new \ReflectionClass(static::class))->getShortName();
    }
}
