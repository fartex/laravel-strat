<?php

namespace Fartex\Strat\Http\Controllers;

use Fartex\Strat\Actions\GetMigrations;
use Fartex\Strat\Http\Requests\MigrationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MigrationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(MigrationRequest $request, GetMigrations $migrations): JsonResponse
    {
        return response()->json($migrations->handle($request->input('per_page', 10)));
    }
}
