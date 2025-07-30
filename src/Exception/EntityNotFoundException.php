<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class EntityNotFoundException extends \RuntimeException
{
    public static function fromId(?int $id): self
    {
        return new self(
            message: sprintf('Entity not found for ID: %s', $id),
            code: Response::HTTP_NOT_FOUND,
        );
    }
}
