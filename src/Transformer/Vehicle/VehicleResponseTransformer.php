<?php

declare(strict_types=1);

namespace App\Transformer\Vehicle;

use App\Entity\Vehicle;
use App\Response\Vehicle\VehicleResponse;

class VehicleResponseTransformer
{
    public function transform(Vehicle $vehicle): VehicleResponse
    {
        return new VehicleResponse(
            id: $vehicle->getId(),
            registrationNumber: $vehicle->getRegistrationNumber(),
            driver: $vehicle->getDriver(),
        );
    }
}
