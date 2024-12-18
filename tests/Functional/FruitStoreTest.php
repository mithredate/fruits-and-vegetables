<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Repository\FruitRepository;
use App\Tests\DataFixtures\FruitBuilder;
use App\Tests\FunctionalTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class FruitStoreTest extends FunctionalTestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_create_fruit_when_data_is_valid(): void
    {
        $fruitData = (new FruitBuilder())->buildArray();
        $this->client->request(Request::METHOD_POST, $this->generateUrl('fruits_store'), [
            'name' => $fruitData['name'],
            'quantity' => $fruitData['quantity'],
            'unit' => $fruitData['unit'],
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        /** @var FruitRepository $fruitRepository */
        $fruitRepository = self::getContainer()->get(FruitRepository::class);
        $this->assertSame(1, $fruitRepository->count());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_return_bad_request_for_invalid_data(): void
    {
        $this->client->request(Request::METHOD_POST, $this->generateUrl('fruits_store'));

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_return_bad_request_for_invalid_unit(): void
    {
        $fruitData = (new FruitBuilder())->buildArray();
        $this->client->request(Request::METHOD_POST, $this->generateUrl('fruits_store'), [
            'name' => $fruitData['name'],
            'quantity' => $fruitData['quantity'],
            'unit' => 'invalid',
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }
}
