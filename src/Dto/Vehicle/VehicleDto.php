<?php

declare(strict_types=1);

namespace App\Dto\Vehicle;

use App\Dto\Contracts\DataInterface;

readonly class VehicleDto implements DataInterface
{
    public function __construct(
        public string $registrationNumber,
        public string $driver,
        public ?int $id = null,
    ) {
    }
}
