<?php

use Fartex\Strat\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(TestCase::class, DatabaseTransactions::class)->in('Feature', 'Unit');
