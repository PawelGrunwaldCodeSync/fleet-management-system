<?php

declare(strict_types=1);

namespace App\Paginator;

use App\Repository\VehicleRepository;
use App\Response\Vehicle\VehiclePaginationResponse;
use App\Transformer\Pagination\PagerfantaPaginationResponseTransformer;
use App\Transformer\Vehicle\VehiclePaginationTransformer;

readonly class VehiclePaginator
{
    public function __construct(
        private VehicleRepository $repository,
        private VehiclePaginationTransformer $vehiclePaginationTransformer,
        private PagerfantaPaginationResponseTransformer $paginationResponseTransformer,
    ) {
    }

    public function getPaginated(int $page, int $limit): VehiclePaginationResponse
    {
        $paginator = $this->repository->paginationQuery();
        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage($page);

        $paginationResponse = $this->paginationResponseTransformer->transform(
            pagerfanta: $paginator,
        );

        return $this->vehiclePaginationTransformer->transform(
            items: $paginator->getCurrentPageResults(),
            paginationResponse: $paginationResponse,
        );
    }
}
