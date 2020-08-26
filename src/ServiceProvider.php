<?php

namespace Aldhix\Altaradmin;

use Illuminate\Support\ServiceProvider as Service;
use Illuminate\Support\Facades\Blade;

class ServiceProvider extends Service
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {   
        $this->loadViewsFrom(__DIR__.'/resources/views/components', 'component');
        $this->publishes([
            __DIR__.'/app' => app_path('/'),
            __DIR__.'/database' => database_path('/'),
            __DIR__.'/resources' => resource_path('/'),
            __DIR__.'/public' => public_path('/'),
        ]);
        Blade::component('component::navbar.logout','alt-navbar-logout');
    }
}