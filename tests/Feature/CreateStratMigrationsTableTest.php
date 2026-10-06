<?php

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    $this->repository = app(Migrator::class)->getRepository();
    $this->repository->createRepository();
    $this->migration = require __DIR__.'/../../database/migrations/0000_00_00_000000_create_strat_migrations_table.php';
});

test('it should drop the legacy migration entry when the table was created under the old name', function () {
    $this->migration->up();
    $this->repository->log('0001_01_01_000000_create_strat_migrations_table', 1);

    $this->migration->up();

    expect(Schema::hasTable('strat_migrations'))->toBeTrue()
        ->and($this->repository->getRan())->not->toContain('0001_01_01_000000_create_strat_migrations_table');
});
