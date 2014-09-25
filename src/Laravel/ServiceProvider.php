<?php namespace StudioIgnis\Evt\Laravel; 

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    public function boot()
    {
        $this->package('studioignis/evt', 'evt', __DIR__.'/../../');

        $this->initGlobalListener();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->bindDispatcher();
        $this->bindListener();
        $this->bindInflector();
    }

    protected function bindDispatcher()
    {
        $this->app->bindShared('StudioIgnis\Evt\EventDispatcher', function ($app)
        {
            return $app->make($app['config']['evt::dispatcher']);
        });
    }

    protected function bindListener()
    {
        $this->app->bindShared('StudioIgnis\Evt\EventListener', function ($app)
        {
            return $app->make(
                $app['config']['evt::listener'],
                [$app['config']['evt::listeners_namespace']]
            );
        });
    }

    protected function bindInflector()
    {
        $this->app->bindShared('StudioIgnis\Evt\Inflection\EventNameInflector', function ($app)
        {
            return $app->make($app['config']['evt::inflector']);
        });
    }

    protected function initGlobalListener()
    {
        /** @var Dispatcher $dispatcher */
        $dispatcher = $this->app['events'];
        $dispatcher->listen($this->app['config']['listen_for'], 'StudioIgnis\Evt\EventListener');
    }
}
