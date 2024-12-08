<?php

namespace App\Tests\Integration\Service;

use App\Repository\FruitRepository;
use App\Repository\VegetableRepository;
use App\Service\StorageService;
use App\Tests\DatabaseTestCase;
use App\Tests\DataFixtures\RequestBuilder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(StorageService::class)]
class StorageServiceTest extends DatabaseTestCase
{
    #[Test]
    public function it_should_store_fruits_from_request(): void
    {
        $request = (new RequestBuilder())->withFruits(count: 10)->build();
        /** @var StorageService $sut */
        $sut = static::getcontainer()->get(StorageService::class);

        $sut->store($request);

        /** @var FruitRepository $fruitRepository */
        $fruitRepository = static::getContainer()->get(FruitRepository::class);

        $this->assertCount(10, $fruitRepository->findAll());
    }

    #[Test]
    public function it_should_store_vegetables_from_request(): void
    {
        $request = (new RequestBuilder())->withvegetables(count: 10)->build();
        /** @var StorageService $sut */
        $sut = static::getcontainer()->get(StorageService::class);

        $sut->store($request);

        /** @var FruitRepository $vegetableRepository */
        $vegetableRepository = static::getContainer()->get(VegetableRepository::class);

        $this->assertCount(10, $vegetableRepository->findAll());
    }

    #[Test]
    public function it_should_parse_input_file(): void
    {
        $request = (string) file_get_contents('request.json');
        /** @var StorageService $sut */
        $sut = static::getcontainer()->get(StorageService::class);

        $sut->store($request);

        /** @var FruitRepository $fruitRepository */
        $fruitRepository = static::getContainer()->get(FruitRepository::class);

        $this->assertSame(10, $fruitRepository->count());

        /** @var VegetableRepository $vegetableRepository */
        $vegetableRepository = static::getContainer()->get(VegetableRepository::class);

        $this->assertSame(10, $vegetableRepository->count());
    }
}
