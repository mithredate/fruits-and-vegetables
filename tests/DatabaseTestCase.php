<?php

declare(strict_types=1);

namespace App\Tests;

use App\Tests\Concerns\InteractsWithDatabase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class DatabaseTestCase extends KernelTestCase
{
    use InteractsWithDatabase;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->bootInteractsWithDatabase();
    }
}
