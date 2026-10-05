<?php

use Fartex\Strat\Http\Controllers\DatabaseStatusController;
use Fartex\Strat\Http\Controllers\IndexController;
use Fartex\Strat\Http\Controllers\MigrationController;
use Fartex\Strat\Http\Controllers\RunMigrationController;
use Fartex\Strat\Http\Controllers\SyncMigrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', IndexController::class);

Route::get('/migrations', MigrationController::class);

Route::post('/sync-migrations', SyncMigrationController::class);

Route::get('/database-status', DatabaseStatusController::class);

Route::post('/run-migrations/{id?}', RunMigrationController::class);
