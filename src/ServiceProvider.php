<?php

namespace Aldhix\Altaradmin;

use Illuminate\Support\ServiceProvider as Service;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use DB;
use Illuminate\Support\Arr;

class ServiceProvider extends Service
{
    /**
     * Register services.
     *
     * @return void
     */
    protected function mergeConfigFrom($path, $key)
    {
        $config = $this->app['config']->get($key, []);

        $this->app['config']->set($key, $this->mergeConfig(require $path, $config));
    }

    protected function mergeConfig(array $original, array $merging)
    {
        $array = array_merge($original, $merging);

        foreach ($original as $key => $value) {
            if (! is_array($value)) {
                continue;
            }

            if (! Arr::exists($merging, $key)) {
                continue;
            }

            if (is_numeric($key)) {
                continue;
            }

            $array[$key] = $this->mergeConfig($value, $merging[$key]);
        }

        return $array;
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/auth.php', 'auth'
        );

        $this->app['router']->aliasMiddleware('altaradmin.role', \Aldhix\Altaradmin\Middleware\AltaradminRole::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {  
        /*try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration");
        }*/

        Schema::defaultStringLength(191);
        
        $this->loadViewsFrom(__DIR__.'/resources/views/components', 'component');
        $this->publishes([
            __DIR__.'/app' => app_path('/'),
            __DIR__.'/database' => database_path('/'),
            __DIR__.'/resources/views/altar' => resource_path('/views/altar'),
        ]);
        Blade::component('component::navbar.logout','alt-navbar-logout');
    }
}