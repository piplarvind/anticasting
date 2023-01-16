<?php

namespace Piplmodules\ReceivingCountry;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Validator;

class ReceivingCountryServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        /*
          |--------------------------------------------------------------------------
          | Configration
          |--------------------------------------------------------------------------
         */

        // The package configration have not been published. Use the defaults.
        $this->mergeConfigFrom(
                __DIR__ . '/config/receivingcountry.php', 'faq'
        );

        // Publish configuration if we need to customize configuration instead of default one.
        $this->publishes([
            __DIR__ . '/config/users.php' => config_path('receivingcountry.php'),
                ], 'config');



        /*
          |--------------------------------------------------------------------------
          | Migrations
          |--------------------------------------------------------------------------
         */

        // You do not need to export them to the application's main database/migrations directory
        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        // Publish migrations if we need to customize migrations instead of default. 
        $this->publishes([
            __DIR__ . '/migrations' => database_path('migrations')
                ], 'migrations');



        /*
          |--------------------------------------------------------------------------
          | Views
          |--------------------------------------------------------------------------
         */

        // The package views have not been published. Use the defaults.
        $this->loadViewsFrom(__DIR__ . '/views', 'ReceivingCountry');

        // Publish views if we need to customize views instead of default one. 
        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/vendor/receivingcountry'),
                ], 'views');




        /*
          |--------------------------------------------------------------------------
          | Translations
          |--------------------------------------------------------------------------
         */

        // Publish translations if we need to customize translations instead of default one. 
        $this->publishes([
            __DIR__ . '/Lang/' => resource_path('lang/vendor/receivingcountry'),
                ], 'lang');




        /*
          |--------------------------------------------------------------------------
          | Public assets
          |--------------------------------------------------------------------------
         */
        $this->publishes([
            __DIR__ . '/Public' => public_path('vendor/receivingcountry'),
                ], 'public');



        /*
          |--------------------------------------------------------------------------
          | Demo languages
          |--------------------------------------------------------------------------
         */
        $languages = config('piplmodules.locales');
        View::share('languages', $languages);

        //create custom phone validation
     
    }

    
    
       
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        /*
          |--------------------------------------------------------------------------
          | Routes and controllers
          |--------------------------------------------------------------------------
         */
        include __DIR__ . '/routes/web.php';
        include __DIR__ . '/routes/api.php';
    }

}
