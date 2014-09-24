<?php namespace StudioIgnis\Evt;

interface EventDispatcher
{
    /**
     * Dispatch events
     *
     * @param array $events
     */
    public function dispatch(array $events);
}
