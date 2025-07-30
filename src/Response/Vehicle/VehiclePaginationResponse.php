<?php

declare(strict_types=1);

namespace App\Response\Vehicle;

use App\Response\Contracts\PaginationResponseInterface;
use App\Response\Pagination\PaginationResponse;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

readonly class VehiclePaginationResponse implements PaginationResponseInterface
{
    /**
     * @param array<int, VehicleResponse> $data
     */
    public function __construct(
        public array $data,

        #[OA\Property(
            ref: new Model(type: PaginationResponse::class)
        )]
        public PaginationResponse $pagination,
    ) {
    }
}
