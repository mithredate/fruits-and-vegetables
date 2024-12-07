<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Fruit;
use App\Entity\Vegetable;
use App\Utils\Collection;
use Doctrine\ORM\EntityManagerInterface;

final class StorageService
{
    public function __construct(
        private readonly RequestParser $requestParser,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function store(string $request): void
    {
        $parsed = $this->requestParser->parse($request);
        $this->entityManager->wrapInTransaction(function () use ($parsed): void {
            $this->storeFruits($parsed->fruits);
            $this->storeVegetables($parsed->vegetables);
            $this->entityManager->flush();
        });
    }

    /** @param Collection<array-key, Fruit> $fruits */
    private function storeFruits(Collection $fruits): void
    {
        $fruits->forEach(function (Fruit $fruit): void {
            $this->entityManager->persist($fruit);
        });
    }

    /** @param Collection<array-key, Vegetable> $vegetables */
    private function storeVegetables(Collection $vegetables): void
    {
        $vegetables->forEach(function (vegetable $vegetable): void {
            $this->entityManager->persist($vegetable);
        });
    }
}
