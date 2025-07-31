<?php

declare(strict_types=1);

namespace App\Response\Vehicle;

use App\Response\Fleet\FleetResponse;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'VehicleResponse',
    description: 'Single vehicle response',
    type: 'object'
)]
readonly class VehicleResponse
{
    public function __construct(
        #[OA\Property(
            description: 'ID of vehicle',
            type: 'integer',
            example: 1,
        )]
        public int $id,

        #[OA\Property(
            description: 'Registration number of vehicle',
            type: 'string',
            example: 'LUB00000',
        )]
        public string $registration_number,

        #[OA\Property(
            description: 'Driver full name of vehicle',
            type: 'string',
            example: 'Jan Kowalski',
        )]
        public string $driver,

        /** @var array<int, FleetResponse> $fleets */
        #[OA\Property(
            description: 'Fleets assigned to vehicle',
            type: 'array',
            items: new OA\Items(
                properties: [
                    new OA\Property(property: 'id', type: 'integer', example: 1),
                    new OA\Property(property: 'name', type: 'string', example: 'Fleet Car'),
                    new OA\Property(property: 'address', type: 'string', example: '20-027 Lublin'),
                    new OA\Property(property: 'working_hours', type: 'string', example: '8:00 - 16:00'),
                ],
                type: 'object'
            ),
            example: [
                [
                    'id' => 1,
                    'name' => 'Jan Kowalski',
                    'address' => '20-027 Lublin, ul. Tysiąclecia',
                    'working_hours' => '8:00 - 16:00',
                ],
                [
                    'id' => 1,
                    'name' => 'Jan Nowak',
                    'address' => '20-027 Lublin, ul. 1 Maja',
                    'working_hours' => null,
                ],
            ],
        )]
        public array $fleets = [],
    ) {
    }
}
