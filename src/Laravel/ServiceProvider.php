<?php namespace StudioIgnis\Evt\Laravel; 

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->package('studioignis/evt', 'evt', __DIR__.'/../../');

        $this->bindDispatcher();
        $this->bindListener();
        $this->bindInflector();
        $this->initGlobalListener();
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
            return $app->make($app['config']['evt::listener']);
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
        $this->app->bindShared('StudioIgnis\Evt\EventListener', function($app)
        {
            return $app->make(
                $app['config']['evt::listener'], [
                    $app['config']['evt::listeners_namespace']
                ]);
        });

        $config = $this->app['config'];

        /** @var Dispatcher $dispatcher */
        $dispatcher = $this->app['events'];
        $dispatcher->listen($config['liste_for'], 'StudioIgnis\Evt\EventListener');
    }
}
