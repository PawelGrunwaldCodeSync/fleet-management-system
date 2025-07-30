<?php

declare(strict_types=1);

namespace App\Request\Contracts;

use App\Dto\Contracts\DataInterface;

interface RequestInterface
{
    public function toDto(): DataInterface;
}
