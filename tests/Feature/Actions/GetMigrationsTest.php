<?php

use Fartex\Strat\Actions\GetMigrations;
use Fartex\Strat\Enum\MigrationStatusEnum;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    (require __DIR__.'/../../../database/migrations/0001_01_01_000000_create_strat_migrations_table.php')->up();

    $this->seedMigration = function (string $migration, string $status) {
        DB::table('strat_migrations')->insert([
            'type' => 'create',
            'status' => $status,
            'table' => 'widgets',
            'database' => 'testing',
            'migration' => $migration,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    };
});

test('it should paginate migrations ordered by migration name', function () {
    ($this->seedMigration)('2024_01_02_000000_second', MigrationStatusEnum::PENDING->value);
    ($this->seedMigration)('2024_01_01_000000_first', MigrationStatusEnum::EXECUTED->value);

    $result = app(GetMigrations::class)->handle();

    expect($result->total())->toBe(2)
        ->and(collect($result->items())->pluck('migration')->all())
        ->toBe(['2024_01_01_000000_first', '2024_01_02_000000_second']);
});

test('it should filter migrations by status', function () {
    ($this->seedMigration)('2024_01_01_000000_first', MigrationStatusEnum::EXECUTED->value);
    ($this->seedMigration)('2024_01_02_000000_second', MigrationStatusEnum::PENDING->value);

    $result = app(GetMigrations::class)->handle(status: MigrationStatusEnum::PENDING->value);

    expect($result->items())->toHaveCount(1)
        ->and($result->items()[0]->migration)->toBe('2024_01_02_000000_second');
});

test('it should respect a custom per page value', function () {
    collect(range(1, 3))->each(fn (int $i) => (
        $this->seedMigration)("2024_01_0{$i}_000000_migration_{$i}", MigrationStatusEnum::PENDING->value
        ));

    $result = app(GetMigrations::class)->handle(perPage: 2);

    expect($result->items())->toHaveCount(2)
        ->and($result->total())->toBe(3)
        ->and($result->perPage())->toBe(2);
});

test('it should returns an empty paginator when there are no migrations', function () {
    $result = app(GetMigrations::class)->handle();

    expect($result->total())->toBe(0);
});
