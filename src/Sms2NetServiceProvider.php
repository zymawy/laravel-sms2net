<?php namespace Zymawy\Sms2Net;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Lang;
use Config;
class Sms2NetServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        Lang::addNamespace('sms2net', __DIR__ . DIRECTORY_SEPARATOR . '/lang');

        if(!file_exists( config_path('sms2net.php') ))
        {
            $this->publishes([
                __DIR__.'/Config/sms2net.php' => config_path('sms2net.php')
            ], 'config');
        }


        if(!file_exists(base_path('resources/lang/'.Config::get('app.locale').'/sms2net.php')))
        {
            $this->publishes([
                __DIR__ . '/lang' => base_path('resources/lang/'.Config::get('app.locale')),
            ]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Sms2Net', function ($app) {
            return new Sms2Net();
        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('Sms2Net');
    }
}
