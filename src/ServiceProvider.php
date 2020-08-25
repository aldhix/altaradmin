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
        $this->loadViewsFrom(__DIR__.'/views', 'altar');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadFactoriesFrom(__DIR__.'/database/factories');

        $this->publishes([
            __DIR__.'/publish-controllers' => app_path('/Http/Controllers'),
            __DIR__.'/views/altar' => resource_path('views/altar'),

        ]);
    }
}