<?php namespace StudioIgnis\Evt\Laravel; 

use StudioIgnis\Evt\EventDispatcher as DispatcherInterface;
use StudioIgnis\Evt\Inflection\EventNameInflector;
use Illuminate\Events\Dispatcher;

class EventDispatcher implements DispatcherInterface
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @var EventNameInflector
     */
    private $inflector;

    public function __construct(Dispatcher $dispatcher, EventNameInflector $inflector)
    {
        $this->dispatcher = $dispatcher;
        $this->inflector = $inflector;
    }

    /**
     * Dispatch events
     *
     * @param array $events
     */
    public function dispatch(array $events)
    {
        foreach ($events as $event)
        {
            $eventName = $this->inflector->getName(get_class($event));

            $this->dispatcher->fire($eventName, $event);
        }
    }
}
