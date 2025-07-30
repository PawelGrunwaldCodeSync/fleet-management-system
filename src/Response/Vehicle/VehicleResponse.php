<?php

declare(strict_types=1);

namespace App\Response\Vehicle;

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
        public string $registrationNumber,

        #[OA\Property(
            description: 'Driver full name of vehicle',
            type: 'string',
            example: 'Jan Kowalski',
        )]
        public string $driver,
    ) {
    }
}
