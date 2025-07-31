<?php

declare(strict_types=1);

namespace App\Transformer\Vehicle;

use App\Entity\Fleet;
use App\Entity\Vehicle;
use App\Response\Pagination\PaginationResponse;
use App\Response\Vehicle\VehiclePaginationResponse;
use App\Transformer\Contracts\PaginationTransformerInterface;
use App\Transformer\Fleet\FleetResponseTransformer;

class VehiclePaginationTransformer implements PaginationTransformerInterface
{
    public function __construct(
        private readonly VehicleResponseTransformer $vehicleResponseTransformer,
        private readonly FleetResponseTransformer $fleetResponseTransformer,
    ) {
    }

    /**
     * @param iterable<Vehicle> $items
     */
    public function transform(
        iterable $items,
        PaginationResponse $paginationResponse,
    ): VehiclePaginationResponse {
        $data = [];

        /** @var Vehicle $vehicle */
        foreach ($items as $vehicle) {
            $fleets = array_map(
                fn (Fleet $fleet) => $this->fleetResponseTransformer->transform($fleet),
                $vehicle->getFleets()->toArray(),
            );

            $data[] = $this->vehicleResponseTransformer->transform(
                vehicle: $vehicle,
                fleets: $fleets,
            );
        }

        return new VehiclePaginationResponse(
            data: $data,
            pagination: $paginationResponse,
        );
    }
}
