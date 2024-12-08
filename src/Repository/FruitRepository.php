<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Fruit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends ServiceEntityRepository<Fruit> */
final class FruitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fruit::class);
    }

    /**
     * @param non-empty-string $search
     *
     * @return list<Fruit>
     */
    public function findByName(string $search): array
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM \App\Entity\Fruit p WHERE p.name LIKE :name'
            )
            ->setParameter('name', "%{$search}%")
            ->getResult();
    }
}
