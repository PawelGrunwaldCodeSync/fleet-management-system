<?php

declare(strict_types=1);

namespace App\Manager;

use App\Dto\Fleet\FleetDto;
use App\Repository\FleetRepository;
use App\Response\Fleet\FleetResponse;
use App\Transformer\Fleet\FleetResponseTransformer;

class FleetManager
{
    public function __construct(
        private readonly FleetRepository $fleetRepository,
        private readonly FleetResponseTransformer $fleetResponseTransformer,
        private readonly VehicleToFleetAssignmentManager $vehicleToFleetAssignmentManager,
        private readonly VehicleToFleetDetachManager $vehicleToFleetDetachManager,
    ) {
    }

    public function storeWithVehicles(FleetDto $dto): FleetResponse
    {
        $fleet = $this->fleetRepository->store($dto);

        $this->vehicleToFleetAssignmentManager->assign(
            fleet: $fleet,
            vehicles: $dto->vehicles,
        );

        return $this->fleetResponseTransformer->transform($fleet);
    }

    public function updateWithVehicles(FleetDto $dto): FleetResponse
    {
        $fleet = $this->fleetRepository->update($dto);

        $this->vehicleToFleetDetachManager->detach(
            fleet: $fleet,
            vehicleIdsToDetach: $dto->vehicle_ids_detach,
        );

        $this->vehicleToFleetAssignmentManager->assign(
            fleet: $fleet,
            vehicles: $dto->vehicles,
        );

        return $this->fleetResponseTransformer->transform($fleet);
    }
}
