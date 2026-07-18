<?php

namespace Fartex\Strat\Http\Controllers;

use Illuminate\Http\JsonResponse;

class RunMigrationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(?int $id = null): JsonResponse
    {
        dd($id);
    }
}
