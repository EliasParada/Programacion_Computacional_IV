<?php

namespace App\Providers;

use Google_Client;
use Illuminate\Support\ServiceProvider;

class GoogleClientProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind('GoogleClient', function ($app) {
        //     return new \Google_Client();
        // });
        $this->app->singleton('GoogleClient', function ($app) {
            return new \Google_Client();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
