<?php

use Fartex\Strat\Enum\MigrationStatusEnum;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    (require __DIR__.'/../../../../database/migrations/0001_01_01_000000_create_strat_migrations_table.php')->up();

    $this->seedMigration = function (string $migration) {
        DB::table('strat_migrations')->insert([
            'type' => 'create',
            'table' => 'widgets',
            'database' => 'testing',
            'migration' => $migration,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'status' => MigrationStatusEnum::PENDING->value,
        ]);
    };
});

test('it should list migrations with a default per page of 10', function () {
    collect(range(1, 12))->each(
        fn (int $i) => ($this->seedMigration)(sprintf('2024_01_01_%06d_migration', $i))
    );

    $this->get($this->stratUrl('/migrations'))
        ->assertOk()
        ->assertJsonCount(10, 'data')
        ->assertJsonPath('total', 12)
        ->assertJsonPath('per_page', 10);
});

test('it should respect a custom per_page parameter', function () {
    ($this->seedMigration)('2024_01_01_000001_migration');
    ($this->seedMigration)('2024_01_01_000002_migration');

    $this->get($this->stratUrl('/migrations?per_page=1'))
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('per_page', 1)
        ->assertJsonPath('total', 2);
});

test('it should reject a non-integer per_page parameter', function () {
    $this->getJson($this->stratUrl('/migrations?per_page=not-a-number'))
        ->assertStatus(422)
        ->assertJsonValidationErrors('per_page');
});
