<?php

namespace Fartex\Strat\Enum;

enum MigrationStatusEnum: string
{
    case PENDING = 'pending';
    case EXECUTED = 'executed';
}
