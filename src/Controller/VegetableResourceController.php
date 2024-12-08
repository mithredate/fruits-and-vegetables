<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Serializer\VegetableSerializer;
use App\Entity\Vegetable;
use App\Repository\VegetableRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class VegetableResourceController
{
    public function __construct(
        private readonly VegetableRepository $vegetableRepository,
        private readonly VegetableSerializer $vegetableSerializer,
    ) {
    }

    #[Route(path: 'vegetables', name: 'vegetables_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $vegetables = $this->vegetableRepository->findAll();

        return new JsonResponse($this->vegetableSerializer->serializeCollection($vegetables), Response::HTTP_OK);
    }

    #[Route(path: 'vegetables/{id}', name: 'vegetables_show', methods: ['GET'])]
    public function show(Vegetable $vegetable): JsonResponse
    {
        return new JsonResponse($this->vegetableSerializer->serialize($vegetable), Response::HTTP_OK);
    }
}
