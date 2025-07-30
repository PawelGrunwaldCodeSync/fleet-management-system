<?php

declare(strict_types=1);

namespace App\Response\Fleet;

use App\Response\Contracts\PaginationResponseInterface;
use App\Response\Pagination\PaginationResponse;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

readonly class FleetPaginationResponse implements PaginationResponseInterface
{
    /**
     * @param array<int, FleetResponse> $data
     */
    public function __construct(
        #[OA\Property(
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/FleetResponse')
        )]
        public array $data,

        #[OA\Property(
            ref: new Model(type: PaginationResponse::class)
        )]
        public PaginationResponse $pagination,
    ) {
    }
}
