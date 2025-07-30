<?php

declare(strict_types=1);

namespace App\Response;

use OpenApi\Attributes as OA;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Schema;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class ValidationFailedResponse extends Response
{
    public function __construct()
    {
        parent::__construct(
            response: SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY,
            description: 'Validation data failed',
            content: new MediaType(
                mediaType: 'application/json',
                schema: new Schema(
                    properties: [
                        new OA\Property(
                            property: 'errors',
                            type: 'array',
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(
                                        property: 'property',
                                        type: 'string',
                                        example: 'name'
                                    ),
                                    new OA\Property(
                                        property: 'message',
                                        type: 'string',
                                        example: 'This value should not be blank.'
                                    ),
                                ],
                                type: 'object'
                            ),
                        ),
                    ],
                    type: 'object'
                ),
            ),
        );
    }
}
