<?php

declare(strict_types=1);

namespace Guham\TaskManagerBundle\Tests;

use Guham\TaskManagerBundle\GuhamTaskManagerBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class GuhamTaskManagerBundleTest extends TestCase
{
    public function testBundle(): void
    {
        $bundle = new GuhamTaskManagerBundle();
        $this->assertInstanceOf(Bundle::class, $bundle);
    }
}
