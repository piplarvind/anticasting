<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        //dd($this->app->environment('production'));
        if($this->app->environment('production')) {
            $this->app['request']->server->set('HTTPS','on'); // this line for larvel HTTPS pagination issue
            \URL::forceScheme('https');
        }
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
    }
}
