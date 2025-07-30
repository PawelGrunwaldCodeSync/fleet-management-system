<?php

declare(strict_types=1);

namespace App\Enum;

enum SortingDirection: string
{
    case DESC = 'desc';
    case ASC = 'asc';
}
