<?php

declare(strict_types=1);

namespace App\Request\Fleet;

use App\Dto\Fleet\FleetDto;
use App\Request\Contracts\RequestInterface;
use App\Request\Vehicle\StoreVehicleRequest;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema]
class StoreFleetRequest implements RequestInterface
{
    #[OA\Property(
        description: 'Name',
        type: 'string',
        example: 'CarFleet',
        nullable: false,
    )]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    #[Assert\Length(max: 150)]
    public ?string $name;

    #[OA\Property(
        description: 'Address',
        type: 'string',
        example: '00-000 Lublin, ul. Jana Pawła II',
        nullable: false,
    )]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type('string')]
    #[Assert\Length(max: 255)]
    public ?string $address;

    #[OA\Property(
        description: 'Working hours',
        type: 'string',
        example: '8:00 - 16:00',
        nullable: true,
    )]
    #[Assert\Type(type: 'string')]
    #[Assert\Length(max: 80)]
    public ?string $working_hours = null;

    /** @var array<int, StoreVehicleRequest>|null $vehicles */
    #[Assert\Valid]
    public ?array $vehicles = null;

    public function toDto(): FleetDto
    {
        $vehicles = array_map(
            fn (StoreVehicleRequest $vehicleRequest) => $vehicleRequest->toDto(),
            $this->vehicles ?? [],
        );

        return new FleetDto(
            name: $this->name ?? '',
            address: $this->address ?? '',
            workingHours: $this->working_hours,
            vehicles: $vehicles,
        );
    }
}
