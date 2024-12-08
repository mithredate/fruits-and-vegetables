<?php declare(strict_types=1);

namespace App\Tests\Integration\Service;

use App\Entity\Fruit;
use App\Entity\Vegetable;
use App\Service\RequestParser;
use App\Tests\DataFixtures\FruitBuilder;
use App\Tests\DataFixtures\RequestBuilder;
use App\Tests\DataFixtures\VegetableBuilder;
use App\Utils\Unit;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

#[CoversClass(RequestParser::class)]
final class RequestParserTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_fail_with_invalid_json(): void
    {
        $brokenRequest = '{"foo":"bar"';
        /** @var RequestParser $sut */
        $sut = static::getContainer()->get(RequestParser::class);

        $this->expectException(\JsonException::class);

        $sut->parse($brokenRequest);
    }
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_fail_with_invalid_data_type(): void
    {
        $brokenRequest = json_encode('test', \JSON_THROW_ON_ERROR);
        /** @var RequestParser $sut */
        $sut = static::getContainer()->get(RequestParser::class);

        $this->expectException(\InvalidArgumentException::class);

        $sut->parse($brokenRequest);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_fail_with_invalid_data(): void
    {
        $invalidRequest = json_encode(['foo' => 'bar'], \JSON_THROW_ON_ERROR);
        /** @var RequestParser $sut */
        $sut = static::getContainer()->get(RequestParser::class);

        $this->expectException(\InvalidArgumentException::class);

        $sut->parse($invalidRequest);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_parse_one_fruit(): void
    {
        $request = (new RequestBuilder())->withFruit(
            (new FruitBuilder())->withQuantity(1)->withUnit(Unit::KiloGram)
        )->build();
        /** @var RequestParser $sut */
        $sut = static::getContainer()->get(RequestParser::class);

        $actual = $sut->parse($request);

        $this->assertCount(1, $actual->fruits);
        $this->assertCount(0, $actual->vegetables);
        $this->assertInstanceOf(Fruit::class, $actual->fruits[0]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_parse_one_vegetable(): void
    {
        $request = (new RequestBuilder())->withvegetable(
            (new VegetableBuilder())->withQuantity(1)->withUnit(Unit::KiloGram)
        )->build();
        /** @var RequestParser $sut */
        $sut = static::getContainer()->get(RequestParser::class);

        $actual = $sut->parse($request);

        $this->assertCount(0, $actual->fruits);
        $this->assertCount(1, $actual->vegetables);
        $this->assertInstanceOf(Vegetable::class, $actual->vegetables[0]);
    }
}
