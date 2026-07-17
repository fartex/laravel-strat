<?php

namespace Fartex\Strat\Actions;

use Illuminate\Support\Facades\DB;

class GetMigrations
{
    /**
     * Execute the action.
     */
    public function handle(): array
    {
        return DB::table('strat_migrations')
            ->orderBy('migration')
            ->get()
            ->map(fn ($migration) => (array) $migration)
            ->all();
    }
}
