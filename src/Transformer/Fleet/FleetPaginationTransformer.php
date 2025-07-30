<?php

declare(strict_types=1);

namespace App\Transformer\Fleet;

use App\Entity\Fleet;
use App\Response\Fleet\FleetPaginationResponse;
use App\Response\Pagination\PaginationResponse;
use App\Transformer\Contracts\PaginationTransformerInterface;

class FleetPaginationTransformer implements PaginationTransformerInterface
{
    public function __construct(
        private readonly FleetResponseTransformer $responseTransformer,
    ) {
    }

    /**
     * @param iterable<Fleet> $items
     */
    public function transform(
        iterable $items,
        PaginationResponse $paginationResponse,
    ): FleetPaginationResponse {
        $data = [];

        /** @var Fleet $fleet */
        foreach ($items as $fleet) {
            $data[] = $this->responseTransformer->transform($fleet);
        }

        return new FleetPaginationResponse(
            data: $data,
            pagination: $paginationResponse,
        );
    }
}
