<?php

declare(strict_types=1);

namespace App\Exception\Request;

use Symfony\Component\HttpFoundation\Response;

class InvalidArgumentTypeException extends \RuntimeException
{
    public static function fromNull(): self
    {
        return new self(
            message: 'Argument Type',
            code: Response::HTTP_BAD_REQUEST,
        );
    }
}
