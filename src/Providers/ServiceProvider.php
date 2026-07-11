<?php

namespace Fartex\Strat\Providers;

use Illuminate\Support\ServiceProvider as BaseProvider;

class ServiceProvider extends BaseProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'strat');

        $this->publishes([
            __DIR__.'/../../dist' => public_path('vendor/strat'),
        ], 'strat-assets');
    }
}
