<?php

namespace Flightsadmin\Admin;

use Flightsadmin\Admin\Commands\Install;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'admin');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'admin');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('admin.php'),
            ], 'config');

            // Registering package commands.
            $this->commands([
                Install::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'admin');

        // Register the main class to use with the facade
        $this->app->singleton('admin', function () {
            return new Admin;
        });
    }
}
