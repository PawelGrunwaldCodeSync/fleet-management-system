<?php

declare(strict_types=1);

namespace App\Response\Fleet;

use App\Response\Vehicle\VehicleResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Attribute\Groups;

readonly class FleetResponse
{
    public function __construct(
        #[Groups(['user:store', 'user:update'])]
        #[OA\Property(
            description: 'ID of fleet',
            type: 'integer',
            example: 1,
        )]
        public int $id,

        #[Groups(['user:store', 'user:update'])]
        #[OA\Property(
            description: 'Name of fleet',
            type: 'string',
            example: 'Car Fleet',
        )]
        public string $name,

        #[Groups(['user:store', 'user:update'])]
        #[OA\Property(
            description: 'Address of fleet',
            type: 'string',
            example: '00-000 Lublin, ul. Jana Pawła II',
        )]
        public string $address,

        #[Groups(['user:store', 'user:update'])]
        #[OA\Property(
            description: 'Working hours',
            type: 'string',
            example: '8:00 - 16:00'
        )]
        public ?string $working_hours = null,

        /** @var array<int, VehicleResponse> $vehicles */
        #[OA\Property(
            description: 'Vehicles assigned to fleet',
            type: 'array',
            items: new OA\Items(
                properties: [
                    new OA\Property(property: 'id', type: 'integer', example: 1),
                    new OA\Property(property: 'registration_number', type: 'string', example: 'LU001'),
                    new OA\Property(property: 'driver', type: 'string', example: 'Jan Kowalski'),
                ],
                type: 'object'
            ),
            example: [
                [
                    'id' => 1,
                    'registration_number' => 'LU001',
                    'driver' => 'Jan Kowalski',
                ],
                [
                    'id' => 2,
                    'registration_number' => 'LU002',
                    'driver' => 'Jan Nowak',
                ],
            ],
        )]
        public array $vehicles = [],
    ) {
    }
}
