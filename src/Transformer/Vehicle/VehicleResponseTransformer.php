<?php

declare(strict_types=1);

namespace App\Transformer\Vehicle;

use App\Entity\Vehicle;
use App\Response\Fleet\FleetResponse;
use App\Response\Vehicle\VehicleResponse;

class VehicleResponseTransformer
{
    /**
     * @param array<int, FleetResponse> $fleets
     */
    public function transform(Vehicle $vehicle, array $fleets = []): VehicleResponse
    {
        return new VehicleResponse(
            id: $vehicle->getId(),
            registration_number: $vehicle->getRegistrationNumber(),
            driver: $vehicle->getDriver(),
            fleets: $fleets,
        );
    }
}
