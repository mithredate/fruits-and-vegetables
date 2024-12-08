<?php declare(strict_types=1);

namespace App\Controller;

use App\Controller\Serializer\FruitSerializer;
use App\Repository\FruitRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route(path: '/fruits', name: 'fruits_index', methods: ['GET'])]
final class FruitIndexController
{
    public function __construct(
        private readonly FruitRepository $fruitRepository,
        private readonly FruitSerializer $fruitSerializer

    ) {
    }

    public function __invoke(): JsonResponse
    {
        $fruits = $this->fruitRepository->findAll();

        return new JsonResponse($this->fruitSerializer->serializeCollection($fruits), Response::HTTP_OK);
    }
}
