<?php

namespace Fartex\Strat\Jobs;

use Fartex\Strat\Actions\SyncMigrations;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SyncMigrationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(SyncMigrations $syncMigrations): void
    {
        $syncMigrations->handle();
    }
}
