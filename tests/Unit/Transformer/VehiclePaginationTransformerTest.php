<?php

declare(strict_types=1);

namespace Unit\Transformer;

use App\Entity\Fleet;
use App\Entity\Vehicle;
use App\Response\Fleet\FleetResponse;
use App\Response\Pagination\PaginationResponse;
use App\Response\Vehicle\VehiclePaginationResponse;
use App\Response\Vehicle\VehicleResponse;
use App\Transformer\Fleet\FleetResponseTransformer;
use App\Transformer\Vehicle\VehiclePaginationTransformer;
use App\Transformer\Vehicle\VehicleResponseTransformer;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class VehiclePaginationTransformerTest extends TestCase
{
    private VehicleResponseTransformer&MockObject $vehicleResponseTransformer;
    private FleetResponseTransformer&MockObject $fleetResponseTransformer;
    private VehiclePaginationTransformer $transformer;

    protected function setUp(): void
    {
        $this->vehicleResponseTransformer = $this->createMock(VehicleResponseTransformer::class);
        $this->fleetResponseTransformer = $this->createMock(FleetResponseTransformer::class);

        $this->transformer = new VehiclePaginationTransformer(
            vehicleResponseTransformer: $this->vehicleResponseTransformer,
            fleetResponseTransformer: $this->fleetResponseTransformer,
        );
    }

    public function testTransform(): void
    {
        $vehicle1 = $this->createMock(Vehicle::class);
        $vehicle2 = $this->createMock(Vehicle::class);

        $fleet = $this->createMock(Fleet::class);

        $vehicle1FleetsCollection = $this->createMock(Collection::class);
        $vehicle1FleetsCollection->expects($this->once())
            ->method('toArray')
            ->willReturn([$fleet]);

        $vehicle2FleetsCollection = $this->createMock(Collection::class);
        $vehicle2FleetsCollection->expects($this->once())
            ->method('toArray')
            ->willReturn([]);

        $vehicle1->expects($this->once())
            ->method('getFleets')
            ->willReturn($vehicle1FleetsCollection);

        $vehicle2->expects($this->once())
            ->method('getFleets')
            ->willReturn($vehicle2FleetsCollection);

        $fleetResponse = new FleetResponse(
            id: 1,
            name: 'Fleet Car',
            address: '20-027 Lublin',
            working_hours: '8:00 - 16:00',
        );

        $vehicleResponse1 = new VehicleResponse(
            id: 1,
            registration_number: 'LU000',
            driver: 'Jan Kowalski',
            fleets: [$fleetResponse],
        );
        $vehicleResponse2 = new VehicleResponse(
            id: 2,
            registration_number: 'LU222',
            driver: 'Jan',
            fleets: [],
        );

        $this->fleetResponseTransformer->expects($this->once())
            ->method('transform')
            ->with($fleet)
            ->willReturn($fleetResponse);

        $this->vehicleResponseTransformer->expects($this->exactly(2))
            ->method('transform')
            ->willReturnMap([
                [$vehicle1, [$fleetResponse], $vehicleResponse1],
                [$vehicle2, [], $vehicleResponse2],
            ]);

        $paginationResponse = new PaginationResponse(
            current_page: 1,
            max_per_page: 10,
            total_items: 2,
            total_pages: 1,
        );

        $result = $this->transformer->transform([$vehicle1, $vehicle2], $paginationResponse);

        $this->assertInstanceOf(VehiclePaginationResponse::class, $result);
        $this->assertSame($paginationResponse, $result->pagination);
        $this->assertSame($vehicleResponse1, $result->data[0]);
        $this->assertSame($vehicleResponse2, $result->data[1]);
    }
}
