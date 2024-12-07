<?php declare(strict_types=1);

namespace App\Utils;

use Traversable;

/**
 * Immutable Collection
 * @template TKey of array-key
 * @template TValue
 * @implements \IteratorAggregate<TKey, TValue>
 * @implements \ArrayAccess<TKey, TValue>
 */
final class Collection implements \IteratorAggregate, \Countable, \ArrayAccess
{
    /** @param array<TKey, TValue> $items */
    public function __construct(private readonly array $items = [])
    {
    }

    public function isEmpty(): bool
    {
        return $this->items === [];
    }

    /**
     * @param TValue $value
     * @return self<TKey|int, TValue>
     */
    public function add(mixed $value): self
    {
        return new self(array_merge($this->items, [$value]));
    }

    /**
     * @param TValue $value
     * @return self<TKey, TValue>
     */
    public function set(int|string $key, mixed $value): self
    {
        return new self(array_merge($this->items, [$key => $value]));
    }

    public function has(int|string $key): bool
    {
        return isset($this->items[$key]);
    }

    public function get(int|string $key): mixed
    {
        return $this->items[$key] ?? null;
    }

    /** @return self<TKey, TValue> */
    public function remove(int|string $key): self
    {
        $items = $this->items;
        unset($items[$key]);

        return new self($items);
    }

    /** @param \Closure(TValue, TKey): void $callback */
    public function forEach(\Closure $callback): void
    {
        foreach ($this->items as $key => $value) {
            $callback($value, $key);
        }
    }

    /**
     * @template TNewValue
     * @param \Closure(TValue): TNewValue $callback
     * @return self<TKey, TNewValue)
     */
    public function map(\Closure $callback): self
    {
        return new self(array_map($callback, $this->items));
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @param \Closure(TValue): bool $criteria
     * @return self<TKey, TValue>
     */
    public function filter(\Closure $criteria): self
    {
        return new self(array_filter($this->items, $criteria));
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new \BadMethodCallException('Unable to set values on collection using array set');
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new \BadMethodCallException('Unable to unset values on collection using array set');
    }
}
