<?php

declare(strict_types=1);

namespace App\Tests;

use App\Tests\Concerns\InteractsWithDatabase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class FunctionalTestCase extends WebTestCase
{
    use InteractsWithDatabase;

    protected KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();

        $this->bootInteractsWithDatabase();
    }

    /** @param array<array-key, mixed> $parameters */
    protected function generateUrl(
        string $route,
        array $parameters = [],
        int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH
    ): string {
        /** @var Router $router */
        $router = static::getContainer()->get('router');
        return $router->generate($route, $parameters, $referenceType);
    }
}
