<?php

namespace Fartex\Strat\Services;

use Illuminate\Support\Facades\DB;

class GetDatabaseStatusService
{
    /**
     * Execute the service.
     */
    public function handle(): array
    {
        return array_map(fn (string $name) => $this->checkConnection($name),
            $this->connectionNames(),
        );
    }

    /**
     * Get the database connection names.
     */
    private function connectionNames(): array
    {
        $connections = config('strat.connections', []);

        return blank($connections) ? [config('database.default')] : $connections;
    }

    /**
     * Check the connection status.
     */
    private function checkConnection(string $name): array
    {
        $start = microtime(true);
        $config = config("database.connections.$name", []);

        $latencyMs = rescue(function () use ($name, $start) {
            DB::connection($name)->getPdo();

            return (int) round((microtime(true) - $start) * 1000);
        }, report: false);

        return [
            'name' => $name,
            'latency_ms' => $latencyMs,
            'online' => $latencyMs !== null,
            'driver' => data_get($config, 'driver'),
            'database' => data_get($config, 'database'),
        ];
    }
}
