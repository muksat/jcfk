<?php

namespace Jcfk\Providers;

use Illuminate\Support\ServiceProvider;
use Jcfk\Auth\ActiveUserProvider;
use Jcfk\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->extend('custom-eloquent',function()
        {
            $model = $this->app['config']['auth.model'];

            return new ActiveUserProvider($this->app['hash'], $model);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
