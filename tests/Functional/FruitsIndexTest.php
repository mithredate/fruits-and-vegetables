<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Controller\FruitResourceController;
use App\Tests\DataFixtures\FruitBuilder;
use App\Tests\FunctionalTestCase;
use App\Utils\Unit;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\HttpFoundation\Request;

#[CoversClass(FruitResourceController::class)]
final class FruitsIndexTest extends FunctionalTestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_return_empty_response_when_nothing_found(): void
    {
        $this->client->request(Request::METHOD_GET, $this->generateUrl('fruits_index'));

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $jsonContent = (string) $this->client->getResponse()->getContent();
        $this->assertJsonStringEqualsJsonString('{"data":[]}', $jsonContent);
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

        $this->client->request(Request::METHOD_GET, $this->generateUrl('fruits_index'));

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $jsonContent = (string) $this->client->getResponse()->getContent();
        $this->assertJsonStringEqualsJsonString(
            '{"data":[{"id":1,"name":"Apple","quantity":"2000 g","links":[{"rel":"self","uri":"\/fruits\/1"}]}]}',
            $jsonContent,
        );
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_search_by_name(): void
    {
        $fruit = (new FruitBuilder())
            ->withName('Apple')
            ->withQuantity(2)
            ->withUnit(Unit::KiloGram)
            ->build();
        $this->entityManager->persist($fruit);
        $this->entityManager->flush();

        $this->client->request(Request::METHOD_GET, $this->generateUrl('fruits_index'), ['search' => 'pp']);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $jsonContent = (string) $this->client->getResponse()->getContent();
        $this->assertJsonStringEqualsJsonString(
            '{"data":[{"id":1,"name":"Apple","quantity":"2000 g","links":[{"rel":"self","uri":"\/fruits\/1"}]}]}',
            $jsonContent,
        );
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_return_results_in_kg_if_requested(): void
    {
        $fruit = (new FruitBuilder())
            ->withName('Apple')
            ->withQuantity(2)
            ->withUnit(Unit::KiloGram)
            ->build();
        $this->entityManager->persist($fruit);
        $this->entityManager->flush();

        $this->client->request(
            Request::METHOD_GET,
            $this->generateUrl('fruits_index'),
            ['unit' => Unit::KiloGram->value]
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $jsonContent = (string) $this->client->getResponse()->getContent();
        $this->assertJsonStringEqualsJsonString(
            '{"data":[{"id":1,"name":"Apple","quantity":"2.000 kg","links":[{"rel":"self","uri":"\/fruits\/1"}]}]}',
            $jsonContent,
        );
    }
}
