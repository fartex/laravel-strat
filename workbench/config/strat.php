<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Local dev override: monitor both the sqlite (default) and pgsql
    | connections so the dashboard can be tested with more than one database.
    |
    */
    'connections' => [
        'sqlite',
        'pgsql',
    ],

];
