<?php

use Fartex\Strat\Actions\SyncMigrations;
use Fartex\Strat\Jobs\SyncMigrationJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Bus;

test('it should implement ShouldQueue', function () {
    expect(new SyncMigrationJob)->toBeInstanceOf(ShouldQueue::class);
});

test('it should sync the migrations', function () {
    $this->mock(SyncMigrations::class)
        ->shouldReceive('handle')
        ->once()
        ->withNoArgs();

    (new SyncMigrationJob)->handle(app(SyncMigrations::class));
});

test('it should be dispatched to the queue', function () {
    Bus::fake();

    SyncMigrationJob::dispatch();

    Bus::assertDispatched(SyncMigrationJob::class);
});
