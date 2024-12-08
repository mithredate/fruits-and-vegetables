<?php

declare(strict_types=1);

namespace App\Controller\Serializer;

use App\Entity\Vegetable;
use App\Utils\Unit;

/** @extends JsonSerializer<Vegetable> */
final class VegetableSerializer extends JsonSerializer
{
    public function transform(object $vegetable): array
    {
        assert($vegetable instanceof Vegetable);

        return [
            'id' => $vegetable->getId(),
            'name' => $vegetable->getName(),
            'quantity' => sprintf('%d %s', $vegetable->getQuantity(), Unit::Gram->value),
            'links' => [
                [
                    'rel' => 'self',
                    'uri' => "/vegetables/{$vegetable->getId()}",
                ],
            ],
        ];
    }
}
