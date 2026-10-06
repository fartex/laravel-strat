<?php

use Fartex\Strat\Enum\MigrationStatusEnum;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    $this->fixtures = __DIR__.'/../../Fixtures/migrations/run';

    $this->migrator = app(Migrator::class);
    $this->migrator->path($this->fixtures);
    $this->migrator->getRepository()->createRepository();
});

test('it should ignore migration events while the strat_migrations table does not exist', function () {
    $this->migrator->run([$this->fixtures]);

    expect(Schema::hasTable('widgets'))->toBeTrue()
        ->and(Schema::hasTable('strat_migrations'))->toBeFalse();
});

test('it should record the migration as executed once the strat_migrations table exists', function () {
    (require __DIR__.'/../../../database/migrations/0000_00_00_000000_create_strat_migrations_table.php')->up();

    $this->migrator->run([$this->fixtures]);

    $row = DB::table('strat_migrations')->where('migration', '2024_01_01_000001_create_widgets_table')->first();

    expect($row->status)->toBe(MigrationStatusEnum::EXECUTED->value)
        ->and($row->executed_at)->not->toBeNull();
});
