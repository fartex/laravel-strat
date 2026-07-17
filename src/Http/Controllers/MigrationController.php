<?php

namespace Fartex\Strat\Http\Controllers;

use Fartex\Strat\Actions\GetMigrations;
use Illuminate\Http\JsonResponse;

class MigrationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetMigrations $migrations): JsonResponse
    {
        return response()->json($migrations->handle());
    }
}
