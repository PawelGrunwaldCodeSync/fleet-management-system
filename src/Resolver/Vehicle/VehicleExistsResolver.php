<?php

declare(strict_types=1);

namespace App\Resolver\Vehicle;

use App\Dto\Vehicle\VehicleDto;
use App\Entity\Vehicle;
use App\Repository\VehicleRepository;

class VehicleExistsResolver
{
    public function __construct(
        private readonly VehicleRepository $vehicleRepository,
    ) {
    }

    public function getVehicleOrStoreIfNotExist(VehicleDto $dto): Vehicle
    {
        $vehicle = $this->vehicleRepository->getOneByRegistrationNumberAndDriver($dto);

        if ($vehicle instanceof Vehicle) {
            return $vehicle;
        }

        return $this->vehicleRepository->store($dto);
    }
}
