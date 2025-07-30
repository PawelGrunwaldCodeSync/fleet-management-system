<?php

declare(strict_types=1);

namespace App\Response\Fleet;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'FleetResponse',
    description: 'Single fleet response',
    type: 'object'
)]
readonly class FleetResponse
{
    public function __construct(
        #[OA\Property(
            description: 'ID of fleet',
            type: 'integer',
            example: 1,
        )]
        public int $id,

        #[OA\Property(
            description: 'Name of fleet',
            type: 'string',
            example: 'Car Fleet',
        )]
        public string $name,

        #[OA\Property(
            description: 'Address of fleet',
            type: 'string',
            example: '00-000 Lublin, ul. Jana Pawła II',
        )]
        public string $address,

        #[OA\Property(
            description: 'Working hours',
            type: 'string',
            example: '8:00 - 16:00'
        )]
        public ?string $workingHours = null,
    ) {
    }
}
