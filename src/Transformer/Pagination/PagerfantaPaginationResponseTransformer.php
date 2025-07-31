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
            current_page: $pagerfanta->getCurrentPage(),
            max_per_page: $pagerfanta->getMaxPerPage(),
            total_items: $pagerfanta->getNbResults(),
            total_pages: $pagerfanta->getNbPages(),
        );
    }
}
