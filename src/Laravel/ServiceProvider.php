<?php namespace StudioIgnis\Evt\Laravel; 

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    public function boot()
    {
        $this->package('studioignis/evt', 'evt');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('StudioIgnis\Evt\Dispatcher', function ($app)
        {
            return $app->make($app['config']['evt::dispatcher']);
        });
    }
}
