<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Controller\FruitResourceController;
use App\Controller\VegetableResourceController;
use App\Tests\DataFixtures\FruitBuilder;
use App\Tests\DataFixtures\VegetableBuilder;
use App\Tests\FunctionalTestCase;
use App\Utils\Unit;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\HttpFoundation\Request;

#[CoversClass(VegetableResourceController::class)]
final class VegetablesIndexTest extends FunctionalTestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_return_empty_response_when_nothing_found(): void
    {
        $this->client->request(Request::METHOD_GET, $this->generateUrl('vegetables_index'));

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $jsonContent = (string) $this->client->getResponse()->getContent();
        $this->assertJsonStringEqualsJsonString('{"data":[]}', $jsonContent);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_return_response_when_found(): void
    {
        $vegetable = (new VegetableBuilder())
            ->withName('Cabbage')
            ->withQuantity(2)
            ->withUnit(Unit::KiloGram)
            ->build();
        $this->entityManager->persist($vegetable);
        $this->entityManager->flush();

        $this->client->request(Request::METHOD_GET, $this->generateUrl('vegetables_index'));

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $jsonContent = (string) $this->client->getResponse()->getContent();
        $this->assertJsonStringEqualsJsonString(
            '{"data":[{"id":1,"name":"Cabbage","quantity":"2000 g","links":[{"rel":"self","uri":"\/vegetables\/1"}]}]}',
            $jsonContent,
        );
    }
}
