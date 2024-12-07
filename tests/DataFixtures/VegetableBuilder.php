<?php declare(strict_types=1);

namespace App\Tests\DataFixtures;

use App\Entity\Vegetable;
use App\Utils\ItemType;
use App\Utils\Unit;

final class VegetableBuilder
{
    private int $id;
    private string $name;
    /** @var positive-int */
    private int $quantity;
    private Unit $unit;

    public function __construct()
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($faker));
        $this->id = random_int(1000, 9999);
        $this->name = $faker->vegetableName();
        $this->quantity = random_int(1, 100);
        $this->unit = random_int(0, 1) > 0 ? Unit::KiloGram : Unit::Gram;
    }

    /** @param positive-int $quantity */
    public function withQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function withUnit(Unit $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function build(): \App\Entity\Vegetable
    {
        $instance = new Vegetable();
        $reflection = new \ReflectionClass($instance);
        $id = $reflection->getProperty('id');
        $id->setAccessible(true);
        $id->setValue($instance, $this->id);
        $instance->setName($this->name);
        $instance->setQuantity($this->quantity, $this->unit);

        return $instance;
    }

    /** @return array{id: int, type: 'vegetable', 'name': string, 'quantity': positive-int, unit: 'g'|'kg'} */
    public function buildArray(): array
    {
        return [
            'id' => $this->id,
            'type' => ItemType::Vegetable->value,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'unit' => $this->unit->value,
        ];
    }
}
