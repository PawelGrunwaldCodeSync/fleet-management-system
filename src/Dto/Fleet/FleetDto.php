<?php

declare(strict_types=1);

namespace App\Dto\Fleet;

use App\Dto\Contracts\DataInterface;
use App\Dto\Vehicle\VehicleDto;

readonly class FleetDto implements DataInterface
{
    /**
     * @param array<int, VehicleDto> $vehicles
     * @param array<int, int>        $vehicle_ids_detach
     */
    public function __construct(
        public string $name,
        public string $address,
        public ?string $workingHours = null,
        public ?int $id = null,
        public array $vehicles = [],
        public array $vehicle_ids_detach = [],
    ) {
    }
}
