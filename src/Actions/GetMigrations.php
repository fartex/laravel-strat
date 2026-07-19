<?php

namespace Fartex\Strat\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class GetMigrations
{
    /**
     * Execute the action.
     */
    public function handle(int $perPage = 15, ?string $status = null): LengthAwarePaginator
    {
        return DB::table('strat_migrations')
            ->when($status, fn ($query) => $query->where('status', $status))
            ->orderBy('migration')
            ->paginate($perPage);
    }
}
