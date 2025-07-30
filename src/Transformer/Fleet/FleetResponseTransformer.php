<?php

declare(strict_types=1);

namespace App\Transformer\Fleet;

use App\Entity\Fleet;
use App\Response\Fleet\FleetResponse;

class FleetResponseTransformer
{
    public function transform(Fleet $fleet): FleetResponse
    {
        return new FleetResponse(
            id: $fleet->getId(),
            name: $fleet->getName(),
            address: $fleet->getAddress(),
            workingHours: $fleet->getWorkingHours(),
        );
    }
}
