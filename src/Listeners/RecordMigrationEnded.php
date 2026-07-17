<?php

namespace Fartex\Strat\Listeners;

use Fartex\Strat\Actions\SyncMigrations;
use Fartex\Strat\Enum\MigrationStatusEnum;
use Illuminate\Database\Events\MigrationEnded;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use function Illuminate\Support\enum_value;

class RecordMigrationEnded
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private SyncMigrations $syncMigrations
    ) {}

    /**
     * Execute the listener.
     */
    public function handle(MigrationEnded $event): void
    {
        $startedAt = RecordMigrationStarted::pull($event->name);

        $this->ensureMigrationIsTracked($event->name);

        DB::table('strat_migrations')
            ->where('migration', $event->name)
            ->update($this->attributesFor($event, $startedAt));
    }

    /**
     * Self-heal the row if this migration was never discovered by a sync before —
     * e.g. a fresh install, or a migration that arrived via git pull.
     */
    private function ensureMigrationIsTracked(string $name): void
    {
        if (! DB::table('strat_migrations')->where('migration', $name)->exists()) {
            $this->syncMigrations->handle();
        }
    }

    /**
     * Build the attributes to persist depending on the migration direction (up/down).
     */
    private function attributesFor(MigrationEnded $event, ?float $startedAt): array
    {
        if ($event->method === 'down') {
            return [
                'executed_at' => null,
                'duration_ms' => null,
                'status' => enum_value(MigrationStatusEnum::PENDING),
            ];
        }

        return [
            'executed_at' => Carbon::now(),
            'status' => enum_value(MigrationStatusEnum::EXECUTED),
            'duration_ms' => $startedAt ? (int) round((microtime(true) - $startedAt) * 1000) : null,
        ];
    }
}
