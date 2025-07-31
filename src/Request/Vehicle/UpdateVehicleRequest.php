<?php

declare(strict_types=1);

namespace App\Request\Vehicle;

use App\Dto\Vehicle\VehicleDto;
use App\Request\Contracts\RequestInterface;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema(
    schema: 'UpdateVehicleRequest',
    type: 'object',
)]
class UpdateVehicleRequest implements RequestInterface
{
    #[OA\Property(
        description: 'Registration number',
        type: 'string',
        example: 'LU000',
        nullable: false,
    )]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    #[Assert\Length(min: 3, max: 150)]
    public ?string $registration_number;

    #[OA\Property(
        description: 'Driver',
        type: 'string',
        example: 'Jan Kowalski',
        nullable: false,
    )]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    #[Assert\Length(max: 100)]
    public ?string $driver;

    public function toDto(): VehicleDto
    {
        return new VehicleDto(
            registrationNumber: $this->registration_number ?? '',
            driver: $this->driver ?? '',
        );
    }
}
