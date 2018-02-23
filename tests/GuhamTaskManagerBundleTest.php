<?php

declare(strict_types=1);

namespace Guham\TaskManagerBundle\Tests;

use Guham\TaskManagerBundle\GuhamTaskManagerBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class GuhamTaskManagerBundleTest extends TestCase
{
    public function testBuild()
    {
        $containerProphecy = $this->prophesize(ContainerBuilder::class);
        $bundle = new GuhamTaskManagerBundle();
        $bundle->build($containerProphecy->reveal());
    }
}
