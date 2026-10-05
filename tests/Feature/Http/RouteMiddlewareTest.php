<?php

use Illuminate\Support\Facades\Route;

test('it should run every dashboard route through the configured middleware before the viewStrat gate', function () {
    $routes = collect(Route::getRoutes()->getRoutes())
        ->filter(fn ($route) => str_starts_with($route->uri(), config('strat.path')));

    expect($routes)->not->toBeEmpty();

    $routes->each(function ($route) {
        expect($route->middleware())->toBe(['web', 'can:viewStrat']);
    });
});

test('it should only accept POST on the routes that change state', function (string $path) {
    $this->get($this->stratUrl($path))->assertMethodNotAllowed();
})->with([
    '/run-migrations',
    '/run-migrations/1',
    '/sync-migrations',
]);
