<?php

declare(strict_types=1);

namespace Unit\Paginator;

use App\Entity\Fleet;
use App\Entity\Vehicle;
use App\Paginator\VehiclePaginator;
use App\Repository\VehicleRepository;
use App\Response\Pagination\PaginationResponse;
use App\Response\Vehicle\VehiclePaginationResponse;
use App\Response\Vehicle\VehicleResponse;
use App\Transformer\Pagination\PagerfantaPaginationResponseTransformer;
use App\Transformer\Vehicle\VehiclePaginationTransformer;
use Pagerfanta\Pagerfanta;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class VehiclePaginatorTest extends TestCase
{
    private VehicleRepository&MockObject $repository;
    private PagerfantaPaginationResponseTransformer&MockObject $paginationResponseTransformer;

    /** @var Pagerfanta<Fleet>&MockObject */
    private Pagerfanta&MockObject $paginator;
    private VehiclePaginationTransformer&MockObject $vehiclePaginationTransformer;
    private VehiclePaginator $vehiclePaginator;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(VehicleRepository::class);
        $this->paginationResponseTransformer = $this->createMock(PagerfantaPaginationResponseTransformer::class);
        $this->paginator = $this->createMock(Pagerfanta::class);
        $this->vehiclePaginationTransformer = $this->createMock(VehiclePaginationTransformer::class);

        $this->vehiclePaginator = new VehiclePaginator(
            $this->repository,
            $this->vehiclePaginationTransformer,
            $this->paginationResponseTransformer,
        );
    }

    public function testGetPaginated(): void
    {
        $page = 2;
        $limit = 5;
        $currentPageResults = [
            $this->createMock(Vehicle::class),
        ];

        $paginationResponse = new PaginationResponse(
            currentPage: 1,
            maxPerPage: 10,
            totalItems: 2,
            totalPages: 1
        );
        $vehicleResponse = new VehicleResponse(
            id: 1,
            registrationNumber: 'LU000',
            driver: 'Jan Kowalski',
        );
        $vehiclePaginationResponse = new VehiclePaginationResponse(
            data: [$vehicleResponse],
            pagination: $paginationResponse,
        );

        $this->repository->expects($this->once())
            ->method('paginationQuery')
            ->willReturn($this->paginator);

        $this->paginator->expects($this->once())
            ->method('setMaxPerPage')
            ->with($limit);

        $this->paginator->expects($this->once())
            ->method('setCurrentPage')
            ->with($page);

        $this->paginator->expects($this->once())
            ->method('getCurrentPageResults')
            ->willReturn($currentPageResults);

        $this->paginationResponseTransformer->expects($this->once())
            ->method('transform')
            ->with($this->paginator)
            ->willReturn($paginationResponse);

        $this->vehiclePaginationTransformer->expects($this->once())
            ->method('transform')
            ->with($currentPageResults, $paginationResponse)
            ->willReturn($vehiclePaginationResponse);

        $result = $this->vehiclePaginator->getPaginated($page, $limit);

        $this->assertSame($vehiclePaginationResponse, $result);
        $this->assertSame($paginationResponse, $result->pagination);
        $this->assertInstanceOf(VehicleResponse::class, $result->data[0]);
        $this->assertSame($vehicleResponse, $result->data[0]);
    }
}
