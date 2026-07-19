<?php

use Fartex\Strat\Actions\RunMigrations;
use Fartex\Strat\Jobs\RunMigrationJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Bus;

test('it should implement ShouldQueue', function () {
    expect(new RunMigrationJob)->toBeInstanceOf(ShouldQueue::class);
});

test('it should run every pending migration when constructed without an id', function () {
    $this->mock(RunMigrations::class)
        ->shouldReceive('handle')
        ->once()
        ->with(null);

    (new RunMigrationJob)->handle(app(RunMigrations::class));
});

test('it should run a single migration when constructed with an id', function () {
    $this->mock(RunMigrations::class)
        ->shouldReceive('handle')
        ->once()
        ->with(42);

    new RunMigrationJob(42)->handle(app(RunMigrations::class));
});

test('it should be dispatched to the queue with an id', function () {
    Bus::fake();

    RunMigrationJob::dispatch(7);

    Bus::assertDispatched(RunMigrationJob::class, function (RunMigrationJob $job) {
        $id = new ReflectionProperty($job, 'id');

        return $id->getValue($job) === 7;
    });
});
