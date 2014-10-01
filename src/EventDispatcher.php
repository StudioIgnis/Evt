<?php namespace StudioIgnis\Evt; 

use StudioIgnis\Evt\Support\Container;

class EventDispatcher implements Dispatcher
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var array
     */
    private $listeners = [];

    public function __construct(Container $container = null)
    {
        $this->container = $container;
    }

    /**
     * Add event listener
     *
     * @param string $event
     * @param string|EventListener $listener
     * @return mixed
     */
    public function addListener($event, $listener)
    {
        $this->listeners[$event][] = $listener;
    }

    /**
     * Dispatch events
     *
     * @param Event[] $events
     */
    public function dispatch(array $events)
    {
        foreach ($events as $event)
        {
            $this->fireListeners($event);
        }
    }

    /**
     * @param $event
     */
    private function fireListeners($event)
    {
        foreach ($this->getListenersFor($event) as $listener)
        {
            $listener = $this->resolveListener($listener);

            $listener->handle($event);
        }
    }

    /**
     * @param Event $event
     * @return array
     */
    private function getListenersFor(Event $event)
    {
        return isset($this->listeners[$event->getEventName()])
            ? $this->listeners[$event->getEventName()]
            : [];
    }

    /**
     * @param $listener
     * @return mixed
     */
    private function resolveListener($listener)
    {
        if (is_string($listener))
        {
            if (!$this->container) {
                throw new \InvalidArgumentException('The listener is a string, but no container was provided.');
            }

            $listener = $this->container->resolve($listener);
        }

        if (!$listener instanceof EventListener)
        {
            throw new \InvalidArgumentException(sprintf(
                'Event listener [%s] should be an instance of [%s]',
                get_class($listener), '\StudioIgnis\Evt\EventListener'
            ));
        }

        return $listener;
    }
}
