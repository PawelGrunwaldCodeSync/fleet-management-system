<?php

declare(strict_types=1);

namespace App\Transformer\Vehicle;

use App\Entity\Vehicle;
use App\Response\Pagination\PaginationResponse;
use App\Response\Vehicle\VehiclePaginationResponse;
use App\Transformer\Contracts\PaginationTransformerInterface;

class VehiclePaginationTransformer implements PaginationTransformerInterface
{
    public function __construct(
        private readonly VehicleResponseTransformer $responseTransformer,
    ) {
    }

    /**
     * @param iterable<Vehicle> $items
     */
    public function transform(
        iterable $items,
        PaginationResponse $paginationResponse,
    ): VehiclePaginationResponse {
        $data = [];

        /** @var Vehicle $vehicle */
        foreach ($items as $vehicle) {
            $data[] = $this->responseTransformer->transform($vehicle);
        }

        return new VehiclePaginationResponse(
            data: $data,
            pagination: $paginationResponse,
        );
    }
}
