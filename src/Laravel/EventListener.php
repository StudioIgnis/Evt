<?php namespace StudioIgnis\Evt\Laravel; 

use Illuminate\Container\Container;
use StudioIgnis\Evt\EventListener as EventListenerInterface;

class EventListener implements EventListenerInterface
{
    /**
     * @var Container
     */
    private $app;

    /**
     * @var string
     */
    private $namespace;

    public function __construct(Container $app, $namespace)
    {
        $this->app = $app;
        $this->namespace = $namespace;
    }
    
    public function handle($event)
    {
        $listenerClassName = $this->getListenerClassName($event);

        $listener = $this->app->make($listenerClassName);

        if (!$listener instanceof EventListenerInterface)
        {
            throw new \DomainException(
                "Domain event listener [$listenerClassName] ".
                "shoud be an instance of [StudioIgnis\\Evt\\EventListener]."
            );
        }

        $listener->handle($event);
    }

    private function getListenerClassName($event)
    {
        $shortName = (new \ReflectionClass($event))->getShortName();

        return $this->namespace.'\\'.$shortName.'Listener';
    }
}
