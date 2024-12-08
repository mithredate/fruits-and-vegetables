<?php

declare(strict_types=1);

namespace App\Controller\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class FruitDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 3, max: 255)]
        public readonly string $name,
        #[Assert\Positive]
        public readonly int $quantity,
        #[Assert\NotBlank]
        #[Assert\Choice(choices: ['kg', 'g'])]
        public readonly string $unit,
    ) {
    }
}
