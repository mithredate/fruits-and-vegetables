<?php

declare(strict_types=1);

namespace App\Service;

use App\Controller\Request\FruitDto;
use App\Entity\Fruit;
use App\Utils\Unit;
use Doctrine\ORM\EntityManagerInterface;

final class UpdateFruitService
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function execute(Fruit $fruit, FruitDto $updated): void
    {
        $fruit->setName($updated->name);
        $fruit->setQuantity($updated->quantity, Unit::from($updated->unit));
        $this->entityManager->persist($fruit);
        $this->entityManager->flush();
    }
}
