<?php

declare(strict_types=1);

namespace App\Controller;

use App\OpenApi\Query\LimitParameterQuery;
use App\OpenApi\Query\PageParameterQuery;
use App\Paginator\VehiclePaginator;
use App\Response\Vehicle\VehiclePaginationResponse;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag(name: 'Vehicle')]
final class VehicleController extends AbstractController
{
    public function __construct(
        private readonly VehiclePaginator $paginator,
    ) {
    }

    #[Route('/api/vehicles', name: 'vehicle_get', methods: ['GET'])]
    #[PageParameterQuery]
    #[LimitParameterQuery]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Get vehicles list',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                ref: new Model(
                    type: VehiclePaginationResponse::class,
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
}
