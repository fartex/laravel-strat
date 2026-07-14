<?php

namespace Fartex\Strat\Http\Controllers;

use Fartex\Strat\Services\GetDatabaseStatusService;
use Illuminate\Http\JsonResponse;

class DatabaseStatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetDatabaseStatusService $service): JsonResponse
    {
        return response()->json($service->handle());
    }
}
