<?php

namespace Putuariepra\SimpleOtp;

use Illuminate\Support\ServiceProvider;

class SimpleOtpServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/otp.php', 'otp'
        );
    }    

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'simpleotp');

        $this->publishes([
            __DIR__.'/../config' => config_path(),
            __DIR__.'/../database/migrations' => database_path('migrations'),
            __DIR__.'/../resources/views' => resource_path('views/vendor/simpleotp'),
        ], 'simpleotp');
    }
}
