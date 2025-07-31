<?php

declare(strict_types=1);

namespace Unit\Transformer;

use App\Entity\Fleet;
use App\Entity\Vehicle;
use App\Response\Fleet\FleetPaginationResponse;
use App\Response\Fleet\FleetResponse;
use App\Response\Pagination\PaginationResponse;
use App\Response\Vehicle\VehicleResponse;
use App\Transformer\Fleet\FleetPaginationTransformer;
use App\Transformer\Fleet\FleetResponseTransformer;
use App\Transformer\Vehicle\VehicleResponseTransformer;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FleetPaginationTransformerTest extends TestCase
{
    private FleetResponseTransformer&MockObject $fleetResponseTransformer;
    private VehicleResponseTransformer&MockObject $vehicleResponseTransformer;
    private FleetPaginationTransformer $transformer;

    protected function setUp(): void
    {
        $this->fleetResponseTransformer = $this->createMock(FleetResponseTransformer::class);
        $this->vehicleResponseTransformer = $this->createMock(VehicleResponseTransformer::class);

        $this->transformer = new FleetPaginationTransformer(
            fleetResponseTransformer: $this->fleetResponseTransformer,
            vehicleResponseTransformer: $this->vehicleResponseTransformer,
        );
    }

    public function testTransform(): void
    {
        $fleet1 = $this->createMock(Fleet::class);
        $fleet2 = $this->createMock(Fleet::class);

        $vehicle = $this->createMock(Vehicle::class);

        $fleet1VehiclesCollection = $this->createMock(Collection::class);
        $fleet1VehiclesCollection->expects($this->once())
            ->method('toArray')
            ->willReturn([$vehicle]);

        $fleet2VehiclesCollection = $this->createMock(Collection::class);
        $fleet2VehiclesCollection->expects($this->once())
            ->method('toArray')
            ->willReturn([]);

        $fleet1->expects($this->once())
            ->method('getVehicles')
            ->willReturn($fleet1VehiclesCollection);

        $fleet2->expects($this->once())
            ->method('getVehicles')
            ->willReturn($fleet2VehiclesCollection);

        $vehicleResponse = new VehicleResponse(
            id: 1,
            registration_number: 'LU000',
            driver: 'Jan Kowalski',
        );

        $fleetResponse1 = new FleetResponse(
            id: 1,
            name: 'Fleet 1',
            address: 'Address 1',
            working_hours: null,
            vehicles: [$vehicleResponse],
        );
        $fleetResponse2 = new FleetResponse(
            id: 2,
            name: 'Fleet 2',
            address: 'Address 2',
            working_hours: '8:00 - 16:00',
            vehicles: [],
        );

        $this->vehicleResponseTransformer->expects($this->once())
            ->method('transform')
            ->with($vehicle)
            ->willReturn($vehicleResponse);

        $this->fleetResponseTransformer->expects($this->exactly(2))
            ->method('transform')
            ->with($fleet1)
            ->willReturnMap([
                [$fleet1, [$vehicleResponse], $fleetResponse1],
                [$fleet2, [], $fleetResponse2],
            ]);

        $paginationResponse = new PaginationResponse(
            current_page: 1,
            max_per_page: 10,
            total_items: 2,
            total_pages: 1,
        );

        $result = $this->transformer->transform([$fleet1, $fleet2], $paginationResponse);

        $this->assertInstanceOf(FleetPaginationResponse::class, $result);
        $this->assertSame($paginationResponse, $result->pagination);
        $this->assertSame($fleetResponse1, $result->data[0]);
        $this->assertSame($fleetResponse2, $result->data[1]);
    }
}
