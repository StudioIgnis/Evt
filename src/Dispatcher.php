<?php namespace StudioIgnis\Evt;

interface Dispatcher
{
    /**
     * Add event listener
     *
     * @param string $event
     * @param string $listener
     * @return mixed
     */
    public function addListener($event, $listener);

    /**
     * Dispatch events
     *
     * @param array $events
     */
    public function dispatch(array $events);
}
