<?php

declare(strict_types=1);

namespace App\Controller;

use App\Paginator\FleetPaginator;
use App\Repository\FleetRepository;
use App\Request\Fleet\StoreFleetRequest;
use App\Request\Fleet\UpdateFleetRequest;
use App\Response\EntityNotFoundResponse;
use App\Response\Fleet\FleetPaginationResponse;
use App\Response\Fleet\FleetResponse;
use App\Response\ValidationFailedResponse;
use App\Transformer\Fleet\FleetResponseTransformer;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: 'Fleet')]
final class FleetController extends AbstractController
{
    public function __construct(
        private readonly FleetRepository $repository,
        private readonly FleetPaginator $paginator,
        private readonly FleetResponseTransformer $responseTransformer,
    ) {
    }

    #[Route('/api/fleets', name: 'fleet_get', methods: ['GET'])]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Get fleets list',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                ref: new Model(
                    type: FleetPaginationResponse::class,
                ),
            ),
        ),
    )]
    public function index(Request $request): JsonResponse
    {
        $page = (int) $request->query->get('page', 1);
        $limit = (int) $request->query->get('limit', 15);

        $response = $this->paginator->getPaginated(page: $page, limit: $limit);

        return $this->json($response);
    }

    #[Route('/api/fleet/store', name: 'fleet_store', methods: ['POST'])]
    #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                ref: new Model(
                    type: StoreFleetRequest::class,
                ),
            ),
        ),
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Store new fleet',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                ref: new Model(
                    type: FleetResponse::class,
                ),
            ),
        ),
    )]
    #[ValidationFailedResponse]
    public function store(StoreFleetRequest $request): JsonResponse
    {
        try {
            $fleet = $this->repository->store($request->toDto());
            $response = $this->responseTransformer->transform($fleet);
        } catch (\Exception $e) {
            return $this->json(
                data: [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ],
                status: $e->getCode(),
            );
        }

        return $this->json(['data' => $response]);
    }

    #[Route('/api/fleet/update', name: 'fleet_update', methods: ['PUT'])]
    #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                ref: new Model(
                    type: UpdateFleetRequest::class,
                ),
            ),
        ),
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Update fleet',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                ref: new Model(
                    type: FleetResponse::class,
                ),
            ),
        ),
    )]
    #[ValidationFailedResponse]
    #[EntityNotFoundResponse]
    public function update(UpdateFleetRequest $request): JsonResponse
    {
        try {
            $fleet = $this->repository->update($request->toDto());
            $response = $this->responseTransformer->transform($fleet);
        } catch (\Exception $e) {
            return $this->json(
                data: [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ],
                status: $e->getCode(),
            );
        }

        return $this->json(['data' => $response]);
    }
}
