<?php

declare(strict_types=1);

namespace Unit\Transformer;

use App\Entity\Vehicle;
use App\Response\Pagination\PaginationResponse;
use App\Response\Vehicle\VehiclePaginationResponse;
use App\Response\Vehicle\VehicleResponse;
use App\Transformer\Vehicle\VehiclePaginationTransformer;
use App\Transformer\Vehicle\VehicleResponseTransformer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class VehiclePaginationTransformerTest extends TestCase
{
    private VehicleResponseTransformer&MockObject $responseTransformer;
    private VehiclePaginationTransformer $transformer;

    protected function setUp(): void
    {
        $this->responseTransformer = $this->createMock(VehicleResponseTransformer::class);
        $this->transformer = new VehiclePaginationTransformer($this->responseTransformer);
    }

    public function testTransform(): void
    {
        $vehicle1 = $this->createMock(Vehicle::class);
        $vehicle2 = $this->createMock(Vehicle::class);

        $vehicleResponse1 = new VehicleResponse(
            id: 1,
            registrationNumber: 'LU000',
            driver: 'Jan Kowalski',
        );
        $vehicleResponse2 = new VehicleResponse(
            id: 2,
            registrationNumber: 'LU222',
            driver: 'Jan',
        );

        $this->responseTransformer->expects($this->exactly(2))
            ->method('transform')
            ->willReturnMap([
                [$vehicle1, $vehicleResponse1],
                [$vehicle2, $vehicleResponse2],
            ]);

        $paginationResponse = new PaginationResponse(
            currentPage: 1,
            maxPerPage: 10,
            totalItems: 2,
            totalPages: 1
        );

        $result = $this->transformer->transform([$vehicle1, $vehicle2], $paginationResponse);

        $this->assertInstanceOf(VehiclePaginationResponse::class, $result);
        $this->assertSame($paginationResponse, $result->pagination);
        $this->assertSame($vehicleResponse1, $result->data[0]);
        $this->assertSame($vehicleResponse2, $result->data[1]);
    }
}
