<?php

declare(strict_types=1);

namespace Unit\Paginator;

use App\Entity\Fleet;
use App\Paginator\FleetPaginator;
use App\Repository\FleetRepository;
use App\Response\Fleet\FleetPaginationResponse;
use App\Response\Fleet\FleetResponse;
use App\Response\Pagination\PaginationResponse;
use App\Transformer\Fleet\FleetPaginationTransformer;
use App\Transformer\Pagination\PagerfantaPaginationResponseTransformer;
use Pagerfanta\Pagerfanta;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FleetPaginatorTest extends TestCase
{
    private FleetRepository&MockObject $repository;
    private PagerfantaPaginationResponseTransformer&MockObject $paginationResponseTransformer;

    /** @var Pagerfanta<Fleet>&MockObject */
    private Pagerfanta&MockObject $paginator;
    private FleetPaginationTransformer&MockObject $fleetPaginationTransformer;
    private FleetPaginator $fleetPaginator;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(FleetRepository::class);
        $this->paginationResponseTransformer = $this->createMock(PagerfantaPaginationResponseTransformer::class);
        $this->paginator = $this->createMock(Pagerfanta::class);
        $this->fleetPaginationTransformer = $this->createMock(FleetPaginationTransformer::class);

        $this->fleetPaginator = new FleetPaginator(
            $this->repository,
            $this->fleetPaginationTransformer,
            $this->paginationResponseTransformer,
        );
    }

    public function testGetPaginated(): void
    {
        $page = 2;
        $limit = 5;
        $currentPageResults = [
            $this->createMock(Fleet::class),
        ];

        $paginationResponse = new PaginationResponse(
            currentPage: 1,
            maxPerPage: 10,
            totalItems: 2,
            totalPages: 1
        );
        $fleetResponse = new FleetResponse(
            id: 1,
            name: 'Fleet',
            address: 'Address',
            workingHours: null,
        );
        $fleetPaginationResponse = new FleetPaginationResponse(
            data: [$fleetResponse],
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

        $this->fleetPaginationTransformer->expects($this->once())
            ->method('transform')
            ->with($currentPageResults, $paginationResponse)
            ->willReturn($fleetPaginationResponse);

        $result = $this->fleetPaginator->getPaginated($page, $limit);

        $this->assertSame($fleetPaginationResponse, $result);
        $this->assertSame($paginationResponse, $result->pagination);
        $this->assertInstanceOf(FleetResponse::class, $result->data[0]);
        $this->assertSame($fleetResponse, $result->data[0]);
    }
}
