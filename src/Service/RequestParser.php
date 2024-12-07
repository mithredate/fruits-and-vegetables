<?php declare(strict_types=1);

namespace App\Service;

use App\Dto\Request;
use App\Entity\Fruit;
use App\Entity\Vegetable;
use App\Utils\Collection;
use App\Utils\ItemType;
use App\Utils\RequestValidator;
use App\Utils\Unit;

final class RequestParser
{
    public function __construct(private readonly RequestValidator $requestValidator)
    {
    }

    public function parse(string $request): Request
    {
        $decoded = json_decode($request, true, 512, \JSON_THROW_ON_ERROR);
        if (!is_array($decoded)) {
            throw new \InvalidArgumentException('Request body is not valid JSON.');
        }

        if (! $this->requestValidator->passes($decoded)) {
            throw new \InvalidArgumentException('Request body is not valid JSON.');
        }

        $allRecords = new Collection($decoded);

        $fruits = $allRecords->filter(fn (array $item) => ItemType::tryFrom($item['type']) === ItemType::Fruit)
            ->map(function (array $item): Fruit {
                $fruit = new Fruit();
                $fruit->setName((string) $item['name']);
                $fruit->setQuantity((int) $item['quantity'], Unit::from((string) $item['unit']));

                return $fruit;
            });

        $vegetables = $allRecords->filter(fn (array $item) => ItemType::tryFrom($item['type']) === ItemType::Vegetable)
            ->map(function (array $item): Vegetable {
                $vegetable = new Vegetable();
                $vegetable->setName((string) $item['name']);
                $vegetable->setQuantity((int) $item['quantity'], Unit::from((string) $item['unit']));

                return $vegetable;
            });

        return new Request($fruits, $vegetables);
    }
}
