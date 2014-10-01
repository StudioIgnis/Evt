<?php namespace StudioIgnis\Evt\Laravel; 

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    public function boot()
    {
        $this->package('studioignis/evt', 'evt', realpath(__DIR__.'/../../'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('StudioIgnis\Evt\Support\Container', function ($app)
        {
            return new Container($app);
        });

        $this->app->bindShared('StudioIgnis\Evt\Dispatcher', function ($app)
        {
            return $app->make($app['config']['evt::dispatcher'], [
                $app['StudioIgnis\Evt\Support\Container']
            ]);
        });
    }
}
