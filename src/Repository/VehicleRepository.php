<?php

declare(strict_types=1);

namespace App\Repository;

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
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('f')
            ->from(Vehicle::class, 'f')
            ->orderBy('f.id', SortingDirection::DESC->value);

        return new Pagerfanta(
            new QueryAdapter($query),
        );
    }
}
