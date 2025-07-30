<?php

declare(strict_types=1);

namespace Unit\Transformer;

use App\Entity\Fleet;
use App\Response\Fleet\FleetPaginationResponse;
use App\Response\Fleet\FleetResponse;
use App\Response\Pagination\PaginationResponse;
use App\Transformer\Fleet\FleetPaginationTransformer;
use App\Transformer\Fleet\FleetResponseTransformer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FleetPaginationTransformerTest extends TestCase
{
    private FleetResponseTransformer&MockObject $responseTransformer;
    private FleetPaginationTransformer $transformer;

    protected function setUp(): void
    {
        $this->responseTransformer = $this->createMock(FleetResponseTransformer::class);
        $this->transformer = new FleetPaginationTransformer($this->responseTransformer);
    }

    public function testTransform(): void
    {
        $fleet1 = $this->createMock(Fleet::class);
        $fleet2 = $this->createMock(Fleet::class);

        $fleetResponse1 = new FleetResponse(
            id: 1,
            name: 'Fleet 1',
            address: 'Address 1',
            workingHours: null,
        );
        $fleetResponse2 = new FleetResponse(
            id: 2,
            name: 'Fleet 2',
            address: 'Address 2',
            workingHours: '8:00 - 16:00',
        );

        $this->responseTransformer->expects($this->exactly(2))
            ->method('transform')
            ->with($fleet1)
            ->willReturnMap([
                [$fleet1, $fleetResponse1],
                [$fleet2, $fleetResponse2],
            ]);

        $paginationResponse = new PaginationResponse(
            currentPage: 1,
            maxPerPage: 10,
            totalItems: 2,
            totalPages: 1
        );

        $result = $this->transformer->transform([$fleet1, $fleet2], $paginationResponse);

        $this->assertInstanceOf(FleetPaginationResponse::class, $result);
        $this->assertSame($paginationResponse, $result->pagination);
        $this->assertSame($fleetResponse1, $result->data[0]);
        $this->assertSame($fleetResponse2, $result->data[1]);
    }
}
