<?php

namespace Jcfk\Providers;

use Illuminate\Support\ServiceProvider;

class MonerisServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Moneris_Gateway::class, function ($app) {
            return \Moneris::create($app['config']['moneris.credentials']);
        });
    }
}