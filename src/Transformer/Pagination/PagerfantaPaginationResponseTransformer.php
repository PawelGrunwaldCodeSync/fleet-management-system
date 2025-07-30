<?php

declare(strict_types=1);

namespace App\Transformer\Pagination;

use App\Response\Pagination\PaginationResponse;
use Pagerfanta\Pagerfanta;

class PagerfantaPaginationResponseTransformer
{
    /**
     * @template T
     *
     * @param Pagerfanta<T> $pagerfanta
     */
    public function transform(
        Pagerfanta $pagerfanta,
    ): PaginationResponse {
        return new PaginationResponse(
            currentPage: $pagerfanta->getCurrentPage(),
            maxPerPage: $pagerfanta->getMaxPerPage(),
            totalItems: $pagerfanta->getNbResults(),
            totalPages: $pagerfanta->getNbPages(),
        );
    }
}
