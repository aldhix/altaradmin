<?php

namespace Aldhix\Altaradmin;

use Illuminate\Support\ServiceProvider as Service;
use Illuminate\Support\Facades\Blade;
use DB;

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
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration");
        }
        
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