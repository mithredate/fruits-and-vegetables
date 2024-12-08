<?php

declare(strict_types=1);

namespace App\Service;

use App\Controller\Request\FruitDto;
use App\Entity\Fruit;
use App\Utils\Unit;
use Doctrine\ORM\EntityManagerInterface;

final class CreateFruitService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function execute(FruitDto $data): Fruit
    {
        $fruit = new Fruit();
        $fruit->setName($data->name);
        $fruit->setQuantity($data->quantity, Unit::from($data->unit));

        $this->entityManager->persist($fruit);
        $this->entityManager->flush();

        return $fruit;
    }
}
