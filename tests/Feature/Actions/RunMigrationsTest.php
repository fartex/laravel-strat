<?php

use Fartex\Strat\Actions\RunMigrations;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    (require __DIR__.'/../../../database/migrations/0001_01_01_000000_create_strat_migrations_table.php')->up();

    $this->migrator = app(Migrator::class);
    $this->migrator->path(__DIR__.'/../../Fixtures/migrations/run');
    $this->migrator->getRepository()->createRepository();

    $this->seedMigration = function (string $migration) {
        return DB::table('strat_migrations')->insertGetId([
            'type' => 'create',
            'table' => 'widgets',
            'status' => 'pending',
            'database' => 'testing',
            'migration' => $migration,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    };
});

test('it should run every pending migration when no id is given', function () {
    app(RunMigrations::class)->handle();

    expect(Schema::hasTable('widgets'))->toBeTrue()
        ->and(Schema::hasTable('gadgets'))->toBeTrue()
        ->and($this->migrator->getRepository()->getRan())->toHaveCount(2);
});

test('it should run only the migration matching the given strat_migrations id', function () {
    $id = ($this->seedMigration)('2024_01_01_000002_create_gadgets_table');

    app(RunMigrations::class)->handle($id);

    expect(Schema::hasTable('gadgets'))->toBeTrue()
        ->and(Schema::hasTable('widgets'))->toBeFalse()
        ->and($this->migrator->getRepository()->getRan())->toBe(['2024_01_01_000002_create_gadgets_table']);
});

test('it should do nothing when the id does not match a strat_migrations row', function () {
    app(RunMigrations::class)->handle(999);

    expect(Schema::hasTable('widgets'))->toBeFalse()
        ->and(Schema::hasTable('gadgets'))->toBeFalse()
        ->and($this->migrator->getRepository()->getRan())->toBe([]);
});

test('it should do nothing when the migration name has no matching file', function () {
    $id = ($this->seedMigration)('2024_01_01_000099_ghost_migration');

    app(RunMigrations::class)->handle($id);

    expect($this->migrator->getRepository()->getRan())->toBe([]);
});

test('it should do nothing when the migration has already run', function () {
    $id = ($this->seedMigration)('2024_01_01_000001_create_widgets_table');

    app(RunMigrations::class)->handle($id);
    expect($this->migrator->getRepository()->getRan())->toBe(['2024_01_01_000001_create_widgets_table']);

    // Running it again by id must be a no-op, not throw.
    app(RunMigrations::class)->handle($id);

    expect($this->migrator->getRepository()->getRan())->toBe(['2024_01_01_000001_create_widgets_table']);
});
