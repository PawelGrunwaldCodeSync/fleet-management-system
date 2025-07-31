<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\Vehicle\VehicleDto;
use App\Entity\Vehicle;
use App\Enum\SortingDirection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @extends ServiceEntityRepository<Vehicle>
 */
class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    /**
     * @return Pagerfanta<Vehicle>
     */
    public function paginationQuery(): Pagerfanta
    {
        $query = $this->createQueryBuilder('v')
            ->select('v')
            ->orderBy('v.id', SortingDirection::DESC->value);

        return new Pagerfanta(
            new QueryAdapter($query),
        );
    }

    public function getOneByRegistrationNumberAndDriver(VehicleDto $dto): ?Vehicle
    {
        $query = $this->createQueryBuilder('v');

        $query->where(
            $query->expr()->andX(
                $query->expr()->eq('v.registrationNumber', ':registration_number'),
                $query->expr()->eq('v.driver', ':driver'),
            ),
        )
            ->setParameter('registration_number', $dto->registrationNumber)
            ->setParameter('driver', $dto->registrationNumber);

        return $query->getQuery()->getOneOrNullResult();
    }

    public function store(VehicleDto $dto): Vehicle
    {
        $entity = new Vehicle();
        $entity->setRegistrationNumber($dto->registrationNumber);
        $entity->setDriver($dto->driver);

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }
}
