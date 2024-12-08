<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Serializer;

use App\Controller\Serializer\JsonSerializer;
use Monolog\Test\TestCase;

final class JsonSerializerTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_serialize_using_transform_method(): void
    {
        $serializer = new class extends JsonSerializer {
            public function transform(object $entity): array
            {
                return ['foo' => 'bar'];
            }
        };

        $serialized = $serializer->serialize(new \stdClass());

        $this->assertSame(['data' => ['foo' => 'bar']], $serialized);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_serialize_collection_using_transform_method(): void
    {
        $serializer = new class extends JsonSerializer {
            public function transform(object $entity): array
            {
                return ['foo' => 'bar'];
            }
        };

        $serialized = $serializer->serializeCollection([new \stdClass(), new \stdClass()]);

        $this->assertSame(['data' => [['foo' => 'bar'], ['foo' => 'bar']]], $serialized);
    }
}
