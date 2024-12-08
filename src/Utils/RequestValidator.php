<?php

declare(strict_types=1);

namespace App\Utils;

use Opis\JsonSchema\Helper;
use Opis\JsonSchema\Validator;

final class RequestValidator
{
    private const SCHEMA = [
        'type' => 'array',
        'items' => [
            'type' => 'object',
            'properties' => [
                'id' => ['type' => 'integer'],
                'name' => ['type' => 'string', 'minLength' => 1, 'maxLength' => 60],
                'quantity' => ['type' => 'integer'],
                'unit' => ['type' => 'string', 'pattern' => '^k?g$'],
                'type' => ['type' => 'string', 'pattern' => '^(fruit|vegetable)$'],
            ],
            'required' => ['id', 'name', 'quantity', 'unit', 'type'],
            'additionalProperties' => false,
        ],
    ];

    /** @param array<array-key, mixed> $data */
    public function passes(array $data): bool
    {
        $validator = new Validator();
        $result = $validator->validate(Helper::toJSON($data), json_encode(self::SCHEMA, \JSON_THROW_ON_ERROR));
        if ($result->hasError()) {
            return false;
        }

        return true;
    }
}
