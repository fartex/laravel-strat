<?php

namespace Workbench\App\Providers;

use Illuminate\Support\ServiceProvider;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // The served workbench app otherwise only knows about the package's
        // own migrations, leaving the demo migrations unreachable when the
        // dashboard runs/syncs them through an actual HTTP request.
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}
