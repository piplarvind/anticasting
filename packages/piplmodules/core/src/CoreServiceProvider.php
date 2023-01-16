<?php

namespace Piplmodules\Core;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class CoreServiceProvider extends ServiceProvider
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
        | Set Locale
        |--------------------------------------------------------------------------
        */
        $locale = \Request::segment(1);
        if( in_array($locale, array_column(config('piplmodules.locales'), 'code')) ){
            \App::setLocale($locale);
        }

        /*
        |--------------------------------------------------------------------------
        | Configration
        |--------------------------------------------------------------------------
        */

        // Publish configration if we need to customize configration instead of default one. 
        $this->publishes([
            __DIR__.'/config/piplmodules.php' => config_path('piplmodules.php'),
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
        $this->loadViewsFrom(__DIR__.'/views', 'Core');

        // Publish views if we need to customize views instead of default one. 
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/vendor/core'),
        ], 'views');




        /*
        |--------------------------------------------------------------------------
        | Translations
        |--------------------------------------------------------------------------
        */

        // Publish translations if we need to customize translations instead of default one. 
        $this->publishes([
            __DIR__.'/Lang/' => resource_path('lang/vendor/core'),
        ], 'lang');




        /*
        |--------------------------------------------------------------------------
        | Public assets
        |--------------------------------------------------------------------------
        */
        $this->publishes([
            __DIR__.'/Public' => public_path('vendor/core'),
        ], 'public');


        /*
        |--------------------------------------------------------------------------
        | Core Global sharing
        |--------------------------------------------------------------------------
        |
        | 1- Load lang
        | 2- AdminMenu
        */

        $packagesDir = realpath(__DIR__.'/../..');
        $modules = scandir($packagesDir);
        $langPath = [];
        foreach ($modules as $module) {
            // Load Lang
            $langPath = $packagesDir.'/'.$module.'/src/lang';
            if(file_exists($langPath)){
                $this->loadTranslationsFrom($packagesDir.'/'.$module.'/src/lang', ucwords($module));
            }
            // Admin menu
            $adminMenuFilePath = $packagesDir.'/'.$module.'/src/menus/admin_menu.php';
            if(file_exists($adminMenuFilePath)){
                include $adminMenuFilePath;
            }
        }
        ksort($adminMenu);
        View::share('adminMenu', $adminMenu);

        /*
        |--------------------------------------------------------------------------
        | Demo languages
        |--------------------------------------------------------------------------
        */
        $languages = config('piplmodules.locales');
        View::share('languages', $languages);
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
        | Configration The package configration have not been published. Use the defaults.
        |--------------------------------------------------------------------------
        */
        $this->mergeConfigFrom(
            __DIR__.'/config/core.php', 'core'
        );

        $this->mergeConfigFrom(
            __DIR__.'/config/piplmodules.php', 'piplmodules'
        );

        include __DIR__.'/routes/web.php';

    }
}
