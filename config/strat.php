<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Names of the connections (defined in config/database.php) that Strat
    | should monitor. Leave empty to monitor only the application's
    | default connection.
    |
    */
    'connections' => [
        // 'mysql',
        // 'pgsql',
        // 'sqlite',
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Execution
    |--------------------------------------------------------------------------
    |
    | Controls how migrations triggered from the dashboard are run. By default
    | they run synchronously, inline with the request, so it works without
    | any extra infrastructure. If the host application already runs a queue
    | worker, set STRAT_MIGRATIONS_ASYNC=true to dispatch a job instead and
    | point it at that worker's connection/queue.
    |
    */
    'migrations' => [
        'async' => env('STRAT_MIGRATIONS_ASYNC', false),
        'connection' => env('STRAT_MIGRATIONS_QUEUE_CONNECTION'),
        'queue' => env('STRAT_MIGRATIONS_QUEUE'),
    ],

];
