<?php declare(strict_types=1);

namespace App\Tests;

use App\Tests\Concerns\InteractsWithDatabase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class FunctionalTestCase extends WebTestCase
{
    use InteractsWithDatabase;

    protected KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();

        $this->bootInteractsWithDatabase();
    }
}
