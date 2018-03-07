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

    public function testDefaultConfig(): void
    {
        $treeBuilder = $this->configuration->getConfigTreeBuilder();
        $config = $this->processor->processConfiguration($this->configuration, []);

        $this->assertInstanceOf(TreeBuilder::class, $treeBuilder);
        $this->assertInstanceOf(ConfigurationInterface::class, $this->configuration);
        $this->assertEquals([
            'homepage_route' => '/',
            'entities' => [
                'Task' => [
                    'class' => '',
                ],
                'Tag' => [
                    'class' => '',
                ],
            ],
        ], $config);
    }

    /**
     * @dataProvider invalidEntityClassValueProvider
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testExceptionToConfigWithInvalidEntityClass($invalidEntityClass): void
    {
        $this->processor->processConfiguration($this->configuration, [
            'guham_task_manager' => [
                'entities' => [
                    'Task' => [
                        'class' => $invalidEntityClass,
                    ],
                ],
            ],
        ]);
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessageRegExp /The class ".+" does not exist./
     */
    public function testExceptionMessageToConfigWithInvalidEntityClass(): void
    {
        $this->processor->processConfiguration($this->configuration, [
            'guham_task_manager' => [
                'entities' => [
                    'Task' => [
                        'class' => 'Foo',
                    ],
                ],
            ],
        ]);
    }

    public function invalidEntityClassValueProvider(): array
    {
        return [
            [null],
            [''],
            ['App\EntityDoesNotExist\Foo'],
        ];
    }
}
