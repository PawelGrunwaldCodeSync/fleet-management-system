<?php

declare(strict_types=1);

namespace App\Manager;

use App\Dto\Vehicle\VehicleDto;
use App\Entity\Fleet;
use App\Resolver\Vehicle\VehicleExistsResolver;
use Doctrine\ORM\EntityManagerInterface;

class VehicleToFleetAssignmentManager
{
    public function __construct(
        private readonly VehicleExistsResolver $vehicleExistsResolver,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param array<int, VehicleDto> $vehicles
     */
    public function assign(Fleet $fleet, array $vehicles): void
    {
        foreach ($vehicles as $vehicleDto) {
            $vehicle = $this->vehicleExistsResolver->getVehicleOrStoreIfNotExist($vehicleDto);

            $fleet->addVehicle($vehicle);
        }

        $this->entityManager->flush();
    }
}
