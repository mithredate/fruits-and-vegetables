<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Request\ApiConfigurationDto;
use App\Controller\Request\FruitDto;
use App\Controller\Serializer\FruitSerializer;
use App\Entity\Fruit;
use App\Repository\FruitRepository;
use App\Service\CreateFruitService;
use App\Utils\Unit;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class FruitResourceController
{
    public function __construct(
        private readonly FruitRepository $fruitRepository,
        private readonly CreateFruitService $createFruitService,
    ) {
    }

    #[Route(path: 'fruits', name: 'fruits_index', methods: ['GET'])]
    public function index(#[MapQueryParameter(
        validationFailedStatusCode: Response::HTTP_NOT_FOUND
    )] Unit $unit = Unit::Gram): JsonResponse
    {
        $fruits = $this->fruitRepository->findAll();
        $serializer = new FruitSerializer($unit);

        return new JsonResponse($serializer->serializeCollection($fruits), Response::HTTP_OK);
    }

    #[Route(path: 'fruits/{id}', name: 'fruits_show', methods: ['GET'])]
    public function show(Fruit $fruit, #[MapQueryParameter(
        validationFailedStatusCode: Response::HTTP_NOT_FOUND
    )] Unit $unit = Unit::Gram): JsonResponse
    {
        $serializer = new FruitSerializer($unit);

        return new JsonResponse($serializer->serialize($fruit));
    }

    #[Route(path: 'fruits', name: 'fruits_store', methods: ['POST'])]
    public function store(#[MapRequestPayload(
        validationFailedStatusCode: Response::HTTP_BAD_REQUEST
    )] FruitDto $fruitDto): JsonResponse
    {
        $fruit = $this->createFruitService->execute($fruitDto);

        return new JsonResponse(
            $this->fruitSerializer->serialize($fruit),
            Response::HTTP_CREATED
        );
    }
}
