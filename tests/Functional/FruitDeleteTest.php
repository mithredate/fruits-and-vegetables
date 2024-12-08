<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Repository\FruitRepository;
use App\Tests\DataFixtures\FruitBuilder;
use App\Tests\FunctionalTestCase;
use App\Utils\Unit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class FruitDeleteTest extends FunctionalTestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_delete_when_found(): void
    {
        $fruit = (new FruitBuilder())->build();
        $this->entityManager->persist($fruit);
        $this->entityManager->flush();

        $this->client->request(Request::METHOD_DELETE, $this->generateUrl('fruits_delete', ['id' => $fruit->getId()]));

        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        /** @var FruitRepository $fruitRepository */
        $fruitRepository = self::getContainer()->get(FruitRepository::class);
        $this->assertSame(0, $fruitRepository->count());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_return_not_found_when_fruit_does_not_exist(): void
    {
        $this->client->request(Request::METHOD_DELETE, $this->generateUrl('fruits_delete', ['id' => 1]));

        $this->assertResponseStatusCodeSame(404);
    }
}
