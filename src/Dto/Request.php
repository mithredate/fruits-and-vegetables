<?php declare(strict_types=1);

namespace App\Dto;

use App\Entity\Fruit;
use App\Entity\Vegetable;
use App\Utils\Collection;

final class Request
{
    /**
     * @param Collection<array-key, Fruit> $fruits
     * @param Collection<array-key, Vegetable> $vegetables
     */
    public function __construct(
        public readonly Collection $fruits,
        public readonly Collection $vegetables
    ) {
    }
}
