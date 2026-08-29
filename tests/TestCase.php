<?php

namespace Fartex\Strat\Tests;

use Fartex\Strat\Providers\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Get package providers.
     */
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        Gate::define('viewStrat', fn ($user = null) => true);
    }

    /**
     * Prefix a Strat dashboard path with its configured base path.
     */
    protected function stratUrl(string $path = ''): string
    {
        return '/'.config('strat.path').$path;
    }
}
