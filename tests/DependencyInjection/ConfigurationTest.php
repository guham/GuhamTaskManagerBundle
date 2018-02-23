<?php

declare(strict_types=1);

namespace Guham\TaskManagerBundle\Tests\DependencyInjection;

use Guham\TaskManagerBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var Processor
     */
    private $processor;

    public function setUp()
    {
        $this->configuration = new Configuration();
        $this->processor = new Processor();
    }

    public function testDefaultConfig()
    {
        $treeBuilder = $this->configuration->getConfigTreeBuilder();
        $config = $this->processor->processConfiguration($this->configuration, [
            'guham_task_manager' => [
                'title' => 'title',
            ],
        ]);

        $this->assertInstanceOf(TreeBuilder::class, $treeBuilder);
        $this->assertInstanceOf(ConfigurationInterface::class, $this->configuration);
        $this->assertEquals(['title' => 'title'], $config);
    }
}
