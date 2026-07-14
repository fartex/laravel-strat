<?php

use Fartex\Strat\Http\Controllers\DatabaseStatusController;
use Fartex\Strat\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/', IndexController::class);

Route::get('/database-status', DatabaseStatusController::class);
