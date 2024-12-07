<?php declare(strict_types=1);

namespace App\Tests\DataFixtures;

final class RequestBuilder
{
    /** @var list<FruitBuilder|VegetableBuilder> */
    private array $items = [];

    public function withFruit(FruitBuilder $builder = new FruitBuilder()): self
    {
        return  $this->withfruits($builder);
    }

    /** @param positive-int $count */
    public function withFruits(FruitBuilder $builder = new FruitBuilder(), int $count = 1): self
    {
        for ($i = 0; $i < $count; $i++) {
            $this->items[] = $builder;
        }

        return  $this;
    }

    public function withVegetable(VegetableBuilder $builder = new VegetableBuilder()): self
    {
        return  $this->withvegetables($builder);
    }

    /** @param positive-int $count */
    public function withVegetables(VegetableBuilder $builder = new VegetableBuilder(), int $count = 1): self
    {
        for ($i = 0; $i < $count; $i++) {
            $this->items[] = $builder;
        }

        return  $this;
    }
    public function withRandomItem(): self
    {
        return random_int(0, 1) > 0 ? $this->withFruit() : $this->withVegetable();
    }

    /** @param int<0, max> $count */
    public function withRandomItems(int $count): self
    {
        return array_reduce(
            array_fill(0, $count, 1),
            fn (self $builder) => $builder->withRandomItem(),
            $this
        );
    }
    public function build(): string
    {
        return json_encode($this->buildArray(), \JSON_THROW_ON_ERROR);
    }

    /** @return list<array{id: int, type: 'vegetable'|'fruit', 'name': string, 'quantity': positive-int, unit: 'g'|'kg'}> */
    public function buildArray(): array
    {
        return array_map(
            fn (FruitBuilder|VegetableBuilder $builder): array => $builder->buildArray(),
            $this->items
        );
    }
}
