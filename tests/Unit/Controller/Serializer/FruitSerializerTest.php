<?php declare(strict_types=1);

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

        $expected = ['data' => ['id' => 12, 'name' => 'Apple', 'quantity' => '2000 g', 'links' => [['rel' => 'self', 'uri' => '/fruits/12']]]];

        $this->assertEquals($expected, $actual);
    }
}
