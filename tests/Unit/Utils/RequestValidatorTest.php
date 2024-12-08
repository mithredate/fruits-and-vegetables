<?php

declare(strict_types=1);

namespace App\Tests\Unit\Utils;

use App\Tests\DataFixtures\RequestBuilder;
use App\Utils\RequestValidator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

#[CoversClass(RequestValidator::class)]
final class RequestValidatorTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_fail_with_invalid_data(): void
    {
        $invalidRequest = [['foo' => 'bar']];
        $sut = new RequestValidator();

        $this->assertFalse($sut->passes($invalidRequest));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_validate_type(): void
    {
        $request = (new RequestBuilder())->withRandomItem()->buildArray();
        $request[0]['type'] = 'foo';

        $sut = new RequestValidator();

        $this->assertFalse($sut->passes($request));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_validate_unit(): void
    {
        $request = (new RequestBuilder())->withRandomItem()->buildArray();
        $request[0]['unit'] = 'foo';

        $sut = new RequestValidator();

        $this->assertFalse($sut->passes($request));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_fail_with_too_long_names(): void
    {
        $request = (new RequestBuilder())->withRandomItem()->buildArray();
        $request[0]['name'] = str_repeat('a', 61);

        $sut = new RequestValidator();

        $this->assertFalse($sut->passes($request));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_fail_when_name_is_missing(): void
    {
        $request = (new RequestBuilder())->withRandomItem()->buildArray();
        $request[0]['name'] = '';

        $sut = new RequestValidator();

        $this->assertFalse($sut->passes($request));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_pass_with_correct_schema(): void
    {
        $request = (new RequestBuilder())->withRandomItems(10)->buildArray();

        $sut = new RequestValidator();

        $this->assertTrue($sut->passes($request));
    }
}
