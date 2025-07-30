<?php

declare(strict_types=1);

namespace App\Response;

use OpenApi\Attributes as OA;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Schema;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class EntityNotFoundResponse extends Response
{
    public function __construct()
    {
        parent::__construct(
            response: SymfonyResponse::HTTP_NOT_FOUND,
            description: 'Entity not found',
            content: new MediaType(
                mediaType: 'application/json',
                schema: new Schema(
                    properties: [
                        new OA\Property(
                            property: 'code',
                            type: 'integer',
                            example: SymfonyResponse::HTTP_NOT_FOUND,
                        ),
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Entity not found for ID: 1',
                        ),
                    ],
                    type: 'object'
                ),
            ),
        );
    }
}
