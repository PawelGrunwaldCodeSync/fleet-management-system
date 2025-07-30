<?php

declare(strict_types=1);

namespace App\Response\Pagination;

use OpenApi\Attributes as OA;

#[OA\Schema]
readonly class PaginationResponse
{
    public function __construct(
        #[OA\Property(type: 'integer', example: 1)]
        public int $currentPage,

        #[OA\Property(type: 'integer', example: 15)]
        public int $maxPerPage,

        #[OA\Property(type: 'integer', example: 6)]
        public int $totalItems,

        #[OA\Property(type: 'integer', example: 1)]
        public int $totalPages,
    ) {
    }
}
