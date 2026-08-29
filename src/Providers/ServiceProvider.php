<?php

namespace Fartex\Strat\Providers;

use Fartex\Strat\Console\Commands\BootstrapCommand;
use Fartex\Strat\Jobs\SyncMigrationJob;
use Fartex\Strat\Listeners\RecordMigrationEnded;
use Fartex\Strat\Listeners\RecordMigrationStarted;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Events\MigrationEnded;
use Illuminate\Database\Events\MigrationStarted;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/strat.php', 'strat');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                BootstrapCommand::class,
            ]);
        }

        $this->app->booted(function () {
            $this->app->make(Schedule::class)
                ->job(new SyncMigrationJob)
                ->everyThirtyMinutes();
        });

        Route::group([
            'prefix' => config('strat.path'),
            'middleware' => 'can:viewStrat',
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        });
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'strat');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->publishes([
            __DIR__.'/../../dist' => public_path('vendor/strat'),
        ], 'strat-assets');

        $this->publishes([
            __DIR__.'/../../config/strat.php' => config_path('strat.php'),
        ], 'strat-config');

        $this->publishes([
            __DIR__.'/../../stubs/StratServiceProvider.stub' => app_path('Providers/StratServiceProvider.php'),
        ], 'strat-provider');

        Event::listen(MigrationEnded::class, RecordMigrationEnded::class);
        Event::listen(MigrationStarted::class, RecordMigrationStarted::class);
    }
}
