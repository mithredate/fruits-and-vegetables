<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Request\FruitDto;
use App\Controller\Serializer\FruitSerializer;
use App\Entity\Fruit;
use App\Service\CreateFruitService;
use App\Service\DeleteFruitService;
use App\Service\SearchFruitService;
use App\Service\UpdateFruitService;
use App\Utils\Unit;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class FruitResourceController
{
    public function __construct(
        private readonly CreateFruitService $createFruitService,
        private readonly SearchFruitService $searchFruitService,
        private readonly DeleteFruitService $deleteFruitService,
        private readonly UpdateFruitService $updateFruitService,
    ) {
    }

    #[Route(path: 'fruits', name: 'fruits_index', methods: ['GET'])]
    public function index(
        #[MapQueryParameter(
            validationFailedStatusCode: Response::HTTP_NOT_FOUND
        )] Unit $unit = Unit::Gram,
        #[MapQueryParameter(
            validationFailedStatusCode: Response::HTTP_NOT_FOUND
        )] string $search = '',
    ): JsonResponse {
        $fruits = $this->searchFruitService->execute($search);

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

        $serializer = new FruitSerializer();

        return new JsonResponse($serializer->serialize($fruit), Response::HTTP_CREATED);
    }

    #[Route(path: 'fruits/{id}', name: 'fruits_delete', methods: ['DELETE'])]
    public function delete(Fruit $fruit): JsonResponse
    {
        $this->deleteFruitService->execute($fruit);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route(path: 'fruits/{id}', name: 'fruits_update', methods: [Request::METHOD_PUT])]
    public function update(Fruit $fruit, #[MapRequestPayload(
        validationFailedStatusCode: Response::HTTP_BAD_REQUEST
    )] FruitDto $fruitDto): JsonResponse
    {
        $this->updateFruitService->execute($fruit, $fruitDto);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
