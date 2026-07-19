<?php

use Fartex\Strat\Actions\GetDatabaseStatus;

test('it should report only the default connection when none are configured', function () {
    config(['strat.connections' => []]);

    $status = app(GetDatabaseStatus::class)->handle();

    expect($status)->toHaveCount(1)
        ->and(data_get($status, '0.name'))->toBe(config('database.default'))
        ->and(data_get($status, '0.online'))->toBeTrue()
        ->and(data_get($status, '0.latency_ms'))->toBeInt()
        ->and(data_get($status, '0.driver'))->toBe('sqlite');
});

test('it should report every connection listed in strat.connections', function () {
    config(
        [
            'strat.connections' => [config('database.default'), 'secondary'],
            'database.connections.secondary' => config('database.connections.'.config('database.default')),
        ]
    );

    $status = app(GetDatabaseStatus::class)->handle();

    expect(collect($status)->pluck('name')->all())
        ->toBe([config('database.default'), 'secondary'])
        ->and(collect($status)->pluck('online')->all())
        ->toBe([true, true]);
});

test('it should report a connection as offline when it cannot connect', function () {
    config([
        'database.connections.broken' => [
            'driver' => 'sqlite',
            'database' => '/nonexistent-path/broken.sqlite',
        ],
        'strat.connections' => ['broken'],
    ]);

    $status = app(GetDatabaseStatus::class)->handle();

    expect($status)->toHaveCount(1)
        ->and(data_get($status, 0))->toMatchArray([
            'online' => false,
            'name' => 'broken',
            'latency_ms' => null,
            'driver' => 'sqlite',
            'database' => '/nonexistent-path/broken.sqlite',
        ]);
});
