<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Serializer\FruitSerializer;
use App\Entity\Fruit;
use App\Repository\FruitRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class FruitResourceController
{
    public function __construct(
        private readonly FruitRepository $fruitRepository,
        private readonly FruitSerializer $fruitSerializer,
    ) {
    }

    #[Route(path: 'fruits', name: 'fruits_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $fruits = $this->fruitRepository->findAll();

        return new JsonResponse($this->fruitSerializer->serializeCollection($fruits), Response::HTTP_OK);
    }

    #[Route(path: 'fruits/{id}', name: 'fruits_show', methods: ['GET'])]
    public function show(Fruit $fruit): JsonResponse
    {
        return new JsonResponse($this->fruitSerializer->serialize($fruit));
    }
}
