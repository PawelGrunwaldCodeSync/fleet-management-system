<?php

declare(strict_types=1);

namespace App\Request\Fleet;

use App\Dto\Fleet\FleetDto;
use App\Request\Contracts\RequestInterface;
use App\Request\Vehicle\UpdateVehicleRequest;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema]
class UpdateFleetRequest implements RequestInterface
{
    #[OA\Property(
        description: 'ID',
        type: 'string',
        example: 1,
        nullable: false,
    )]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type(type: 'integer')]
    public ?int $id;

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
    #[Assert\Blank]
    #[Assert\Type(type: 'string')]
    #[Assert\Length(max: 80)]
    public ?string $workingHours = null;

    /** @var array<int, UpdateVehicleRequest>|null $vehicles */
    #[Assert\Valid]
    public ?array $vehicles = null;

    /** @var array<int, int>|null $vehicle_ids_detach */
    #[OA\Property(
        description: 'Vehicle ids to detach',
        type: 'array',
        items: new OA\Items(type: 'integer'),
        example: [1, 2, 3],
        nullable: true,
    )]
    #[Assert\Type('array')]
    #[Assert\All([
        new Assert\Type('integer'),
    ])]
    public ?array $vehicle_ids_detach = null;

    public function toDto(): FleetDto
    {
        $vehicles = array_map(
            fn (UpdateVehicleRequest $vehicleRequest) => $vehicleRequest->toDto(),
            $this->vehicles ?? [],
        );

        return new FleetDto(
            name: $this->name ?? '',
            address: $this->address ?? '',
            workingHours: $this->workingHours,
            id: $this->id,
            vehicles: $vehicles,
            vehicle_ids_detach: $this->vehicle_ids_detach ?? [],
        );
    }
}
