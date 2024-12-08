<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Fruit;
use Doctrine\ORM\EntityManagerInterface;

final class DeleteFruitService
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function execute(Fruit $fruit): void
    {
        $this->entityManager->remove($fruit);
        $this->entityManager->flush();
    }
}
