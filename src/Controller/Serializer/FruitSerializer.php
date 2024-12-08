<?php

declare(strict_types=1);

namespace App\Controller\Serializer;

use App\Entity\Fruit;
use App\Utils\Unit;

/** @extends JsonSerializer<Fruit> */
final class FruitSerializer extends JsonSerializer
{
    public function transform(object $fruit): array
    {
        assert($fruit instanceof Fruit);

        return [
            'id' => $fruit->getId(),
            'name' => $fruit->getName(),
            'quantity' => sprintf('%d %s', $fruit->getQuantity(), Unit::Gram->value),
            'links' => [
                [
                    'rel' => 'self',
                    'uri' => "/fruits/{$fruit->getId()}",
                ],
            ],
        ];
    }
}
