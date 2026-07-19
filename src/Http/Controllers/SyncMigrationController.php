<?php

namespace Fartex\Strat\Http\Controllers;

use Fartex\Strat\Actions\SyncMigrations;
use Illuminate\Http\JsonResponse;

class SyncMigrationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SyncMigrations $syncMigrations): JsonResponse
    {
        $syncMigrations->handle();

        return response()->json(['synced' => true]);
    }
}
