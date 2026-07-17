<?php

namespace Fartex\Strat\Listeners;

use Illuminate\Database\Events\MigrationStarted;
use Illuminate\Support\Arr;

class RecordMigrationStarted
{
    /**
     * Start times for migrations currently running.
     */
    private static array $startedAt = [];

    /**
     * Execute the listener.
     */
    public function handle(MigrationStarted $event): void
    {
        self::$startedAt[$event->name] = microtime(true);
    }

    /**
     * Get and clear the recorded start time for a migration, if any.
     */
    public static function pull(string $name): ?float
    {
        return Arr::pull(self::$startedAt, $name);
    }
}
