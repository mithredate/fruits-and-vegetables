<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Serializer;

use App\Controller\Serializer\FruitSerializer;
use App\Tests\DataFixtures\FruitBuilder;
use App\Utils\Unit;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FruitSerializer::class)]
final class FruitSerializerTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_transform(): void
    {
        $serializer = new FruitSerializer();
        $fruit = (new FruitBuilder())
            ->withId(12)
            ->withName('Apple')
            ->withQuantity(2)
            ->withUnit(Unit::KiloGram)
            ->build();

        $actual = $serializer->serialize($fruit);

        $expected = ['data' => [
            'id' => 12,
            'name' => 'Apple',
            'quantity' => '2000.000 g',
            'links' => [['rel' => 'self', 'uri' => '/fruits/12']],
        ]];

        $this->assertEquals($expected, $actual);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_transform_to_kg(): void
    {
        $serializer = new FruitSerializer(Unit::KiloGram);
        $fruit = (new FruitBuilder())
            ->withId(12)
            ->withName('Apple')
            ->withQuantity(2)
            ->withUnit(Unit::Gram)
            ->build();

        $actual = $serializer->serialize($fruit);

        $expected = ['data' => [
            'id' => 12,
            'name' => 'Apple',
            'quantity' => '0.002 kg',
            'links' => [['rel' => 'self', 'uri' => '/fruits/12']],
        ]];

        $this->assertEquals($expected, $actual);
    }
}
