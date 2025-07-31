<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Fleet;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;

class VehicleToFleetDetachManager
{
    public function __construct(
        private readonly VehicleRepository $vehicleRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param array<int, int> $vehicleIdsToDetach
     */
    public function detach(Fleet $fleet, array $vehicleIdsToDetach): void
    {
        foreach ($vehicleIdsToDetach as $vehicleId) {
            $vehicle = $this->vehicleRepository->find($vehicleId);

            if ($vehicle) {
                $fleet->removeVehicle($vehicle);
            }
        }

        $this->entityManager->flush();
    }
}
