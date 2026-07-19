<?php

namespace Fartex\Strat\Http\Controllers;

use Fartex\Strat\Actions\RunMigrations;
use Fartex\Strat\Jobs\RunMigrationJob;
use Illuminate\Http\JsonResponse;

class RunMigrationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RunMigrations $runMigrations, ?int $id = null): JsonResponse
    {
        if (! config('strat.migrations.async')) {
            $runMigrations->handle($id);

            return response()->json(['status' => 'completed']);
        }

        RunMigrationJob::dispatch($id)
            ->onConnection(config('strat.migrations.connection'))
            ->onQueue(config('strat.migrations.queue'));

        return response()->json(['status' => 'queued']);
    }
}
