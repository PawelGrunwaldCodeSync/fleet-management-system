<?php

declare(strict_types=1);

namespace App\Transformer\Fleet;

use App\Entity\Fleet;
use App\Response\Fleet\FleetResponse;
use App\Response\Vehicle\VehicleResponse;

class FleetResponseTransformer
{
    /**
     * @param array<int, VehicleResponse> $vehicles
     */
    public function transform(Fleet $fleet, array $vehicles = []): FleetResponse
    {
        return new FleetResponse(
            id: $fleet->getId(),
            name: $fleet->getName(),
            address: $fleet->getAddress(),
            working_hours: $fleet->getWorkingHours(),
            vehicles: $vehicles,
        );
    }
}
