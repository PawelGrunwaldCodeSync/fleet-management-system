<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\Fleet\FleetDto;
use App\Entity\Fleet;
use App\Enum\SortingDirection;
use App\Exception\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @extends ServiceEntityRepository<Fleet>
 */
class FleetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fleet::class);
    }

    /**
     * @return Pagerfanta<Fleet>
     */
    public function paginationQuery(): Pagerfanta
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('f')
            ->from(Fleet::class, 'f')
            ->orderBy('f.id', SortingDirection::DESC->value);

        return new Pagerfanta(
            new QueryAdapter($query),
        );
    }

    public function store(FleetDto $dto): Fleet
    {
        $entity = new Fleet();
        $entity->setName($dto->getName());
        $entity->setAddress($dto->getAddress());
        $entity->setWorkingHours($dto->getWorkingHours());

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }

    public function update(FleetDto $dto): Fleet
    {
        $entity = $this->find($dto->getId());

        if (!$entity) {
            throw EntityNotFoundException::fromId($dto->getId());
        }

        $entity->setName($dto->getName());
        $entity->setAddress($dto->getAddress());
        $entity->setWorkingHours($dto->getWorkingHours());

        $this->getEntityManager()->flush();

        return $entity;
    }
}
