<?php

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    (require __DIR__.'/../../../../database/migrations/0001_01_01_000000_create_strat_migrations_table.php')->up();
});

test('it should sync migrations and report success', function () {
    $migrator = app(Migrator::class);
    $migrator->path(__DIR__.'/../../../Fixtures/migrations/sync');
    $migrator->getRepository()->createRepository();

    $this->get($this->stratUrl('/sync-migrations'))
        ->assertOk()
        ->assertExactJson(['synced' => true]);

    expect(DB::table('strat_migrations')->count())->toBe(3);
});

test('it should report success even when there is nothing to sync', function () {
    $this->get($this->stratUrl('/sync-migrations'))
        ->assertOk()
        ->assertExactJson(['synced' => true]);

    expect(DB::table('strat_migrations')->count())->toBe(0);
});
