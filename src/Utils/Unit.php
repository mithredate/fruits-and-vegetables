<?php declare(strict_types=1);

namespace App\Utils;

enum Unit: string
{
    case Gram = 'g';
    case KiloGram = 'kg';

    public function toGrams(int $value): int
    {
        return match($this) {
            self::Gram => $value,
            self::KiloGram => $value * 1000,
        };
    }
}
