<?php

namespace Fartex\Strat\Enum;

enum MigrationTypeEnum: string
{
    case DROP = 'drop';
    case ALTER = 'alter';
    case CREATE = 'create';
    case RENAME = 'rename';
    case UNKNOWN = 'unknown';
}
