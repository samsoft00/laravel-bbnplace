<?php

namespace Samsoft00\Bbnplace;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Samsoft00\Bbnplace\Libs\BSGateway;

class SmsMessengerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $config = realpath(__DIR__.'/../resources/config/smsmessenger.php');

        $this->publishes([
            $config => config_path('smsmessenger.php')
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('laravel-bbnplace', function () {
            return new SmsMessenger(new Client(), new BSGateway());
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-bbnplace'];
    }


}
