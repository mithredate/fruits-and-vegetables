<?php declare(strict_types=1);

namespace App\Tests\Functional;

use App\Controller\FruitIndexController;
use App\Tests\DataFixtures\FruitBuilder;
use App\Tests\FunctionalTestCase;
use App\Utils\Unit;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(FruitIndexController::class)]
final class FruitsIndexTest extends FunctionalTestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_return_empty_response_when_nothing_found(): void
    {
        $this->client->request('GET', '/fruits');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $jsonContent = (string) $this->client->getResponse()->getContent();
        $this->assertJsonStringEqualsJsonString($jsonContent, '{"data":[]}');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_return_response_when_found(): void
    {
        $fruit = (new FruitBuilder())
            ->withName('Apple')
            ->withQuantity(2)
            ->withUnit(Unit::KiloGram)
            ->build();
        $this->entityManager->persist($fruit);
        $this->entityManager->flush();

        $this->client->request('GET', '/fruits');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $jsonContent = (string) $this->client->getResponse()->getContent();
        $this->assertJsonStringEqualsJsonString($jsonContent, '{"data":[{"id":1,"name":"Apple","quantity":"2000 g","links":[{"rel":"self","uri":"\/fruits\/1"}]}]}');
    }
}
