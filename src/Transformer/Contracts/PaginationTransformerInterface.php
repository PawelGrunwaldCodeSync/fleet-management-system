<?php

declare(strict_types=1);

namespace App\Transformer\Contracts;

use App\Response\Contracts\PaginationResponseInterface;
use App\Response\Pagination\PaginationResponse;

interface PaginationTransformerInterface
{
    /**
     * @template T
     *
     * @param iterable<T> $items
     */
    public function transform(
        iterable $items,
        PaginationResponse $paginationResponse,
    ): PaginationResponseInterface;
}
