<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Service\StorageService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class AppFixtures extends Fixture
{
    public function __construct(private readonly StorageService $storageService)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $request = (string) file_get_contents('request.json');

        $this->storageService->store($request);
    }
}
