<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if($this->app->environment('local')) {
            URL::forceScheme('https');
        }

        if (env('APP_ENV') !== 'local') {
            $this->app['request']->server->set('HTTPS', true);
        }

        if (env('FORCE_HTTPS', false)) {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
