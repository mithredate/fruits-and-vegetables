<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Entity\Fruit;
use App\Repository\FruitRepository;
use App\Tests\DataFixtures\FruitBuilder;
use App\Tests\FunctionalTestCase;
use App\Utils\Unit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class FruitUpdateTest extends FunctionalTestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_create_fruit_when_data_is_valid(): void
    {
        $fruit = (new FruitBuilder())
            ->withName('Apple')
            ->withQuantity(2)
            ->withUnit(Unit::KiloGram)
            ->build();
        $this->entityManager->persist($fruit);
        $this->entityManager->flush();
        self::assertSame('Apple', $fruit->getName());
        self::assertSame(2 * 1000, $fruit->getQuantity());

        $this->client->request(Request::METHOD_PUT, $this->generateUrl('fruits_update', ['id' => $fruit->getId()]), [
            'name' => 'Banana',
            'quantity' => 3,
            'unit' => Unit::Gram->value,
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        /** @var FruitRepository $fruitRepository */
        $fruitRepository = self::getContainer()->get(FruitRepository::class);
        $actual = $fruitRepository->find($fruit->getId());
        self::assertInstanceOf(Fruit::class, $actual);
        self::assertSame('Banana', $actual->getName());
        self::assertSame(3, $actual->getQuantity());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_return_bad_request_for_invalid_data(): void
    {
        $fruit = (new FruitBuilder())
            ->withName('Apple')
            ->withQuantity(2)
            ->withUnit(Unit::KiloGram)
            ->build();
        $this->entityManager->persist($fruit);
        $this->entityManager->flush();

        $this->client->request(Request::METHOD_PUT, $this->generateUrl('fruits_update', ['id' => $fruit->getId()]));

        $this->assertResponseStatusCodeSame(400);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_return_not_found_when_fruit_does_not_exist(): void
    {
        $this->client->request(Request::METHOD_PUT, $this->generateUrl('fruits_update', ['id' => 1]));

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
