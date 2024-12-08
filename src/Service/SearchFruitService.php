<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Fruit;
use App\Repository\FruitRepository;

final class SearchFruitService
{

    public function __construct(private readonly FruitRepository $fruitRepository)
    {
    }

    /** @return list<Fruit> */
    public function execute(string $search = ''): array
    {
        return $search === ''
            ? $this->fruitRepository->findAll()
            : $this->fruitRepository->findByName($search);
    }
}
