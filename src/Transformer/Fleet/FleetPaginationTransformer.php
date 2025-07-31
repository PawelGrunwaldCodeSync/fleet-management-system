<?php

declare(strict_types=1);

namespace App\Transformer\Fleet;

use App\Entity\Fleet;
use App\Entity\Vehicle;
use App\Response\Fleet\FleetPaginationResponse;
use App\Response\Pagination\PaginationResponse;
use App\Transformer\Contracts\PaginationTransformerInterface;
use App\Transformer\Vehicle\VehicleResponseTransformer;

class FleetPaginationTransformer implements PaginationTransformerInterface
{
    public function __construct(
        private readonly FleetResponseTransformer $fleetResponseTransformer,
        private readonly VehicleResponseTransformer $vehicleResponseTransformer,
    ) {
    }

    /**
     * @param iterable<Fleet> $items
     */
    public function transform(
        iterable $items,
        PaginationResponse $paginationResponse,
    ): FleetPaginationResponse {
        $data = [];

        /** @var Fleet $fleet */
        foreach ($items as $fleet) {
            $vehicles = array_map(
                fn (Vehicle $vehicle) => $this->vehicleResponseTransformer->transform($vehicle),
                $fleet->getVehicles()->toArray(),
            );

            $data[] = $this->fleetResponseTransformer->transform(
                fleet: $fleet,
                vehicles: $vehicles,
            );
        }

        return new FleetPaginationResponse(
            data: $data,
            pagination: $paginationResponse,
        );
    }
}
