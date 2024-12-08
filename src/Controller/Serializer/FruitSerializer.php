<?php

declare(strict_types=1);

namespace App\Controller\Serializer;

use App\Entity\Fruit;
use App\Utils\Unit;

/** @extends JsonSerializer<Fruit> */
final class FruitSerializer extends JsonSerializer
{
    public function __construct(private readonly Unit $unit = Unit::Gram)
    {
    }

    public function transform(object $fruit): array
    {
        assert($fruit instanceof Fruit);

        return [
            'id' => $fruit->getId(),
            'name' => $fruit->getName(),
            'quantity' => sprintf('%4.3f %s', $this->unit->fromGrams($fruit->getQuantity()), $this->unit->value),
            'links' => [
                [
                    'rel' => 'self',
                    'uri' => "/fruits/{$fruit->getId()}",
                ],
            ],
        ];
    }
}
