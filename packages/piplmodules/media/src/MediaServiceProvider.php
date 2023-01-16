<?php

namespace Piplmodules\Media;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class MediaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        /*
        |--------------------------------------------------------------------------
        | Configration
        |--------------------------------------------------------------------------
        */

        // The package configration have not been published. Use the defaults.
        $this->mergeConfigFrom(
            __DIR__.'/config/media.php', 'media'
        );

        // Publish configration if we need to customize configration instead of default one. 
        $this->publishes([
            __DIR__.'/config/media.php' => config_path('media.php'),
        ], 'config');



        /*
        |--------------------------------------------------------------------------
        | Migrations
        |--------------------------------------------------------------------------
        */

        // You do not need to export them to the application's main database/migrations directory
        $this->loadMigrationsFrom(__DIR__.'/migrations');

        // Publish migrations if we need to customize migrations instead of default. 
        $this->publishes([
            __DIR__.'/migrations' => database_path('migrations')
        ], 'migrations');



        /*
        |--------------------------------------------------------------------------
        | Views
        |--------------------------------------------------------------------------
        */

        // The package views have not been published. Use the defaults.
        $this->loadViewsFrom(__DIR__.'/views', 'Media');

        // Publish views if we need to customize views instead of default one. 
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/vendor/media'),
        ], 'views');




        /*
        |--------------------------------------------------------------------------
        | Translations
        |--------------------------------------------------------------------------
        */

        // Publish translations if we need to customize translations instead of default one. 
        $this->publishes([
            __DIR__.'/Lang/' => resource_path('lang/vendor/media'),
        ], 'lang');




        /*
        |--------------------------------------------------------------------------
        | Public assets
        |--------------------------------------------------------------------------
        */
        $this->publishes([
            __DIR__.'/Public' => public_path('vendor/media'),
        ], 'public');


    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        /*
        |--------------------------------------------------------------------------
        | Routes and controllers
        |--------------------------------------------------------------------------
        */
        include __DIR__.'/routes/web.php';
        include __DIR__.'/routes/api.php';
        //$this->app->make('Piplmodules\Media\Controllers\MediaApiController');
        //$this->app->make('Piplmodules\Media\Controllers\MediaController');
    }
}
