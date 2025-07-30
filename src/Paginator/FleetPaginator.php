<?php

declare(strict_types=1);

namespace App\Paginator;

use App\Repository\FleetRepository;
use App\Response\Fleet\FleetPaginationResponse;
use App\Transformer\Fleet\FleetPaginationTransformer;
use App\Transformer\Pagination\PagerfantaPaginationResponseTransformer;

readonly class FleetPaginator
{
    public function __construct(
        private FleetRepository $repository,
        private FleetPaginationTransformer $fleetPaginationTransformer,
        private PagerfantaPaginationResponseTransformer $paginationResponseTransformer,
    ) {
    }

    public function getPaginated(int $page, int $limit): FleetPaginationResponse
    {
        $paginator = $this->repository->paginationQuery();
        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage($page);

        $paginationResponse = $this->paginationResponseTransformer->transform(
            pagerfanta: $paginator,
        );

        return $this->fleetPaginationTransformer->transform(
            items: $paginator->getCurrentPageResults(),
            paginationResponse: $paginationResponse,
        );
    }
}
