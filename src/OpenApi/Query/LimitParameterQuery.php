<?php

declare(strict_types=1);

namespace App\OpenApi\Query;

use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class LimitParameterQuery extends OA\QueryParameter
{
    public function __construct()
    {
        parent::__construct(
            parameter: 'limit',
            name: 'limit',
            description: 'Limit results of pagination',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'integer', default: 15),
        );
    }
}
