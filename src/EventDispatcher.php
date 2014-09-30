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

    public function __construct(Container $container)
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
        return isset($this->listeners[$event->getName()])
            ? $this->listeners[$event->getName()]
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
            $listener = $this->container->resolve($listener);
        }

        if (!$listener instanceof EventListener)
        {
            throw new \DomainException(sprintf(
                'Event listener [%s] should be an instance of [%s]',
                get_class($listener), '\StudioIgnis\Evt\EventListener'
            ));
        }

        return $listener;
    }
}
