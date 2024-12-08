<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Serializer;

use App\Controller\Serializer\FruitSerializer;
use App\Controller\Serializer\VegetableSerializer;
use App\Tests\DataFixtures\FruitBuilder;
use App\Tests\DataFixtures\VegetableBuilder;
use App\Utils\Unit;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FruitSerializer::class)]
final class VegetableSerializerTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_transform(): void
    {
        $serializer = new VegetableSerializer();
        $fruit = (new VegetableBuilder())
            ->withId(12)
            ->withName('Cabbage')
            ->withQuantity(2)
            ->withUnit(Unit::KiloGram)
            ->build();

        $actual = $serializer->serialize($fruit);

        $expected = ['data' => [
            'id' => 12,
            'name' => 'Cabbage',
            'quantity' => '2000 g',
            'links' => [['rel' => 'self', 'uri' => '/vegetables/12']],
        ]];

        $this->assertEquals($expected, $actual);
    }
}
