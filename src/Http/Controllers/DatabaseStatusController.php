<?php

namespace Fartex\Strat\Http\Controllers;

use Fartex\Strat\Actions\GetDatabaseStatus;
use Illuminate\Http\JsonResponse;

class DatabaseStatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetDatabaseStatus $status): JsonResponse
    {
        return response()->json($status->handle());
    }
}
