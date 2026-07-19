<?php

namespace Fartex\Strat\Jobs;

use Fartex\Strat\Actions\RunMigrations;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RunMigrationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly ?int $id = null
    ) {}

    /**
     * Execute the job.
     */
    public function handle(RunMigrations $runMigrations): void
    {
        $runMigrations->handle($this->id);
    }
}
