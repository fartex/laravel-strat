<?php

use Fartex\Strat\Jobs\RunMigrationJob;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    (require __DIR__.'/../../../../database/migrations/0001_01_01_000000_create_strat_migrations_table.php')->up();

    $this->migrator = app(Migrator::class);
    $this->migrator->path(__DIR__.'/../../../Fixtures/migrations/run');
    $this->migrator->getRepository()->createRepository();

    config(['strat.migrations.async' => false]);
});

test('it should run every pending migration synchronously by default', function () {
    $this->get('/run-migrations')
        ->assertOk()
        ->assertExactJson(['status' => 'completed']);

    expect(Schema::hasTable('widgets'))->toBeTrue()
        ->and(Schema::hasTable('gadgets'))->toBeTrue();
});

test('it should run a single migration synchronously when an id is given', function () {
    $id = DB::table('strat_migrations')->insertGetId([
        'migration' => '2024_01_01_000002_create_gadgets_table',
        'table' => 'gadgets',
        'database' => 'testing',
        'type' => 'create',
        'status' => 'pending',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->get("/run-migrations/{$id}")
        ->assertOk()
        ->assertExactJson(['status' => 'completed']);

    expect(Schema::hasTable('gadgets'))->toBeTrue()
        ->and(Schema::hasTable('widgets'))->toBeFalse();
});

test('it should dispatch a queued job when async migrations are enabled', function () {
    config([
        'strat.migrations.async' => true,
        'strat.migrations.connection' => 'sync',
        'strat.migrations.queue' => 'migrations',
    ]);

    Bus::fake();

    $this->get('/run-migrations/5')
        ->assertOk()
        ->assertExactJson(['status' => 'queued']);

    Bus::assertDispatched(RunMigrationJob::class, function (RunMigrationJob $job) {
        $id = new ReflectionProperty($job, 'id');

        return $id->getValue($job) === 5
            && $job->connection === 'sync'
            && $job->queue === 'migrations';
    });

    expect(Schema::hasTable('gadgets'))->toBeFalse();
});
