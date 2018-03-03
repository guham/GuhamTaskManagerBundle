<?php

declare(strict_types=1);

namespace Guham\TaskManagerBundle\Tests\Form\DataTransformer;

use Guham\TaskManagerBundle\Form\DataTransformer\NullToDateTimeDataTransformer;
use PHPUnit\Framework\TestCase;

class NullToDateTimeDataTransformerTest extends TestCase
{
    /**
     * @var NullToDateTimeDataTransformer
     */
    protected $transformer;

    protected function setUp()
    {
        $this->transformer = new NullToDateTimeDataTransformer();
    }

    protected function tearDown()
    {
        $this->transformer = null;
    }

    public function testTransform(): void
    {
        $this->assertNull($this->transformer->transform(null));
        $this->assertTrue(\is_a($this->transformer->transform(new \DateTime()), \DateTime ::class));
    }

    public function testReverseTransformNull(): void
    {
        $this->assertTrue(\is_a($this->transformer->reverseTransform(null), \DateTimeImmutable::class));
    }

    public function testReverseTransformNotNull(): void
    {
        $date = new \DateTimeImmutable();
        $this->assertSame($date, $this->transformer->reverseTransform($date));
    }
}
