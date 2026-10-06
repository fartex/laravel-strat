<?php

namespace Fartex\Strat\Tests;

use Fartex\Strat\Providers\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
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

        // Tests create tables (strat_migrations, migrations, fixture tables), and
        // MySQL commits DDL implicitly, so a rolled-back transaction can't undo
        // them. Start every test from an empty database instead.
        // WARNING: this drops every table in the test connection, so never point
        // the test suite at a database you care about.
        Schema::dropAllTables();

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
