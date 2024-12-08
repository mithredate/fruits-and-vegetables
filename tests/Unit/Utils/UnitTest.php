<?php

declare(strict_types=1);

namespace App\Tests\Unit\Utils;

use App\Utils\Unit;
use PHPUnit\Framework\TestCase;

final class UnitTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_convert_grams_to_kilo(): void
    {
        $this->assertSame(0.002, Unit::KiloGram->fromGrams(2));
    }
}
