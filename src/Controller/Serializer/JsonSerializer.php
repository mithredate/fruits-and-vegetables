<?php declare(strict_types=1);

namespace App\Controller\Serializer;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

/** @template T of object */
abstract class JsonSerializer extends TransformerAbstract
{
    /**
     * @param T $entity
     * @return array<string, mixed>
     */
    abstract public function transform(object $entity): array;

    /**
     * @param T $entity
     * @return array<string, mixed>
     */
    public function serialize(object $entity): array
    {
        $resource = new Item($entity, $this);
        $manager = new Manager();

        return $manager->createData($resource)->toArray();
    }

    /**
     * @param list<T> $entities
     * @return array{data: array<string, mixed>}
     */
    public function serializeCollection(array $entities): array
    {
        $resource = new Collection($entities, $this);
        $manager = new Manager();

        return $manager->createData($resource)->toArray();
    }
}
