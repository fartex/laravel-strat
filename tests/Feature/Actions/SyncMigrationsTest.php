<?php

use Fartex\Strat\Actions\SyncMigrations;
use Fartex\Strat\Enum\MigrationStatusEnum;
use Fartex\Strat\Enum\MigrationTypeEnum;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    (require __DIR__.'/../../../database/migrations/0001_01_01_000000_create_strat_migrations_table.php')->up();
});

test('it should do nothing when there are no migration files to sync', function () {
    app(SyncMigrations::class)->handle();

    expect(DB::table('strat_migrations')->count())->toBe(0);
});

test('it should upsert each migration file, resolving its table, type, status, batch and database', function () {
    $migrator = app(Migrator::class);
    $migrator->path(__DIR__.'/../../Fixtures/migrations/sync');
    $migrator->getRepository()->createRepository();

    config(['database.connections.reporting' => [
        'driver' => 'sqlite',
        'database' => '/var/data/reporting.sqlite',
    ]]);

    $migrator->runPending([
        __DIR__.'/../../Fixtures/migrations/sync/2024_01_01_000001_create_widgets_table.php',
    ]);

    app(SyncMigrations::class)->handle();

    $rows = DB::table('strat_migrations')->get()->keyBy('migration');

    expect($rows)->toHaveCount(3)
        ->and($rows->has('0001_01_01_000000_create_strat_migrations_table'))->toBeFalse();

    $created = $rows->get('2024_01_01_000001_create_widgets_table');
    expect($created->status)->toBe(MigrationStatusEnum::EXECUTED->value)
        ->and($created->type)->toBe(MigrationTypeEnum::CREATE->value)
        ->and($created->table)->toBe('create_widgets')
        ->and($created->batch)->toBe(1)
        ->and($created->database)->toBe(':memory:');

    $renamed = $rows->get('2024_01_01_000002_rename_widgets_table');
    expect($renamed->status)->toBe(MigrationStatusEnum::PENDING->value)
        ->and($renamed->type)->toBe(MigrationTypeEnum::RENAME->value)
        ->and($renamed->table)->toBe('rename_widgets')
        ->and($renamed->batch)->toBeNull();

    $dropped = $rows->get('2024_01_01_000003_drop_gadgets_table');
    expect($dropped->status)->toBe(MigrationStatusEnum::PENDING->value)
        ->and($dropped->type)->toBe(MigrationTypeEnum::DROP->value)
        ->and($dropped->table)->toBe('drop_gadgets')
        ->and($dropped->database)->toBe('reporting.sqlite');
});

test('it should re-sync status without touching the original created_at', function () {
    $migrator = app(Migrator::class);
    $migrator->path(__DIR__.'/../../Fixtures/migrations/sync');
    $migrator->getRepository()->createRepository();

    config(['database.connections.reporting' => [
        'driver' => 'sqlite',
        'database' => '/var/data/reporting.sqlite',
    ]]);

    Carbon::setTestNow('2024-01-01 00:00:00');
    app(SyncMigrations::class)->handle();

    $firstSync = DB::table('strat_migrations')
        ->where('migration', '2024_01_01_000002_rename_widgets_table')
        ->first();

    expect($firstSync->status)->toBe(MigrationStatusEnum::PENDING->value);

    Carbon::setTestNow('2024-06-01 00:00:00');

    $migrator->runPending([
        __DIR__.'/../../Fixtures/migrations/sync/2024_01_01_000001_create_widgets_table.php',
        __DIR__.'/../../Fixtures/migrations/sync/2024_01_01_000002_rename_widgets_table.php',
    ]);

    app(SyncMigrations::class)->handle();

    $secondSync = DB::table('strat_migrations')
        ->where('migration', '2024_01_01_000002_rename_widgets_table')
        ->first();

    expect($secondSync->status)->toBe(MigrationStatusEnum::EXECUTED->value)
        ->and($secondSync->batch)->toBe(1)
        ->and((string) $secondSync->created_at)->toBe((string) $firstSync->created_at)
        ->and((string) $secondSync->updated_at)->not->toBe((string) $firstSync->updated_at);

    Carbon::setTestNow();
});
