<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Controller\FruitResourceController;
use App\Tests\DataFixtures\FruitBuilder;
use App\Tests\FunctionalTestCase;
use App\Utils\Unit;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(FruitResourceController::class)]
final class FruitsShowTest extends FunctionalTestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_return_not_found_when_missing(): void
    {
        $this->client->request('GET', $this->generateUrl('fruits_show', ['id' => 1]));

        $this->assertResponseStatusCodeSame(404);
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

        $this->client->request('GET', $this->generateUrl('fruits_show', ['id' => $fruit->getId()]));

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $jsonContent = (string) $this->client->getResponse()->getContent();
        $this->assertJsonStringEqualsJsonString(
            '{"data":{"id":1,"name":"Apple","quantity":"2000 g","links":[{"rel":"self","uri":"\/fruits\/1"}]}}',
            $jsonContent,
        );
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_return_response_in_kg_if_requested(): void
    {
        $fruit = (new FruitBuilder())
            ->withName('Apple')
            ->withQuantity(20)
            ->withUnit(Unit::Gram)
            ->build();
        $this->entityManager->persist($fruit);
        $this->entityManager->flush();

        $this->client->request('GET', $this->generateUrl(
            'fruits_show',
            ['id' => $fruit->getId()]
        ), ['unit' => Unit::KiloGram->value]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $jsonContent = (string) $this->client->getResponse()->getContent();
        $this->assertJsonStringEqualsJsonString(
            '{"data":{"id":1,"name":"Apple","quantity":"0.020 kg","links":[{"rel":"self","uri":"\/fruits\/1"}]}}',
            $jsonContent,
        );
    }
}
