<?php

declare(strict_types=1);

namespace App\Dto\Fleet;

use App\Dto\Contracts\DataInterface;

readonly class FleetDto implements DataInterface
{
    public function __construct(
        private ?string $name,
        private ?string $address,
        private ?string $workingHours = null,
        private ?int $id = null,
    ) {
    }

    public function getName(): string
    {
        return $this->name ?? '';
    }

    public function getAddress(): string
    {
        return $this->address ?? '';
    }

    public function getWorkingHours(): ?string
    {
        return $this->workingHours;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
