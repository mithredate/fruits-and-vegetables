<?php

declare(strict_types=1);

namespace App\Tests\Unit\Utils;

use App\Utils\Collection;
use Countable;
use PHPUnit\Framework\TestCase;
use Traversable;

final class CollectionTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_empty_on_creation(): void
    {
        $sut = new Collection();

        $this->assertTrue($sut->isEmpty());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_add_items(): void
    {
        $sut = new Collection();

        $actual = $sut->add('dummy');

        $this->assertFalse($actual->isEmpty());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_immutable(): void
    {
        $sut = new Collection();

        $sut->add('dummy');

        $this->assertTrue($sut->isEmpty());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_set_with_string_keys(): void
    {
        $sut = new Collection();

        $actual = $sut->set('key', 'value');

        $this->assertFalse($actual->isEmpty());
        $this->assertTrue($actual->has('key'));
        $this->assertSame('value', $actual->get('key'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_set_initial_values(): void
    {
        $sut = new Collection(['key' => 'value']);

        $this->assertTrue($sut->has('key'));
        $this->assertSame('value', $sut->get('key'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_remove_existing(): void
    {
        $sut = new Collection(['key' => 'value']);

        $actual = $sut->remove('key');

        $this->assertTrue($actual->isEmpty());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_remove_immutably(): void
    {
        $sut = new Collection(['key' => 'value']);

        $sut->remove('key');

        $this->assertFalse($sut->isEmpty());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_traversable(): void
    {
        $this->assertInstanceOf(Traversable::class, new Collection());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_countable(): void
    {
        $this->assertInstanceOf(Countable::class, new Collection());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_run_callback_in_foreach(): void
    {
        $sut = new Collection(['key' => 'value']);
        $callback = function (string $value, string $key): bool {
            $this->assertSame('value', $value);
            $this->assertSame('key', $key);
            throw new \RuntimeException();
        };

        $this->expectException(\RuntimeException::class);

        $sut->foreach($callback);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_map_values(): void
    {
        $sut = new Collection(['key' => 'value']);
        $callback = function (string $value): string {
            $this->assertSame('value', $value);
            return 'new-value';
        };

        $actual = $sut->map($callback);

        $this->assertSame('new-value', $actual->get('key'));
        $this->assertSame('value', $sut->get('key'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_filter_values(): void
    {
        $sut = new Collection(['key' => 'value', 'key2' => 'value2']);
        $criteria = function (string $value): bool {
            return $value === 'value';
        };

        $actual = $sut->filter($criteria);

        $this->assertTrue($actual->has('key'));
        $this->assertFalse($actual->has('key2'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_array_access(): void
    {
        $sut = new Collection(['key' => 'value']);

        $this->assertSame('value', $sut['key']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_return_null_for_missing_values(): void
    {
        $sut = new Collection();

        $this->assertNull($sut['missing']);
    }
}
