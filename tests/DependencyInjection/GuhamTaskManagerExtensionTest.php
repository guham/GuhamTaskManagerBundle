<?php

declare(strict_types=1);

namespace Guham\TaskManagerBundle\Tests\DependencyInjection;

use Guham\TaskManagerBundle\DependencyInjection\GuhamTaskManagerExtension;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class GuhamTaskManagerExtensionTest extends TestCase
{
    const DEFAULT_CONFIG = ['guham_task_manager' => [
        'title' => 'title',
    ]];
    const DEFAULT_MINUTES = [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55];

    private $extension;

    protected function setUp()
    {
        $this->extension = new GuhamTaskManagerExtension();
    }

    protected function tearDown()
    {
        $this->extension = null;
    }

    public function testConstruct()
    {
        $this->extension = new GuhamTaskManagerExtension();

        $this->assertInstanceOf(PrependExtensionInterface::class, $this->extension);
        $this->assertInstanceOf(ExtensionInterface::class, $this->extension);
    }

    public function testPrepend()
    {
        $containerBuilderProphecy = $this->prophesize(ContainerBuilder::class);

        $containerBuilderProphecy->prependExtensionConfig('stof_doctrine_extensions', Argument::type('array'))->shouldBeCalled();

        $containerBuilderProphecy->prependExtensionConfig('easy_admin', [
            'site_name' => 'Task Manager - Admin',
            'design' => [
                'brand_color' => '#4F805D',
                'menu' => [
                    ['label' => 'menu.homepage', 'route' => 'home', 'icon' => 'home'],
                    ['entity' => 'Task', 'icon' => 'list', 'default' => true],
                    ['entity' => 'Tag', 'icon' => 'list'],
                ],
            ],
            'list' => [
                'max_results' => 30,
                'actions' => [
                    ['name' => 'edit', 'icon' => 'pencil'],
                    ['name' => 'delete', 'icon' => 'trash'],
                    ['name' => 'new', 'icon' => 'plus'],
                ],
            ],
            'entities' => [
                'Task' => [
                    'class' => 'Guham\TaskManagerBundle\Entity\Task',
                    'label' => 'menu.tasks',
                    'list' => [
                        'title' => 'label.tasks',
                        'actions' => [
                            ['name' => 'new', 'label' => 'add.task', 'icon' => 'plus'],
                        ],
                        'fields' => [
                            ['property' => 'id', 'label' => 'label.id'],
                            ['property' => 'title', 'label' => 'label.title'],
                            ['property' => 'startDate', 'label' => 'label.startdate'],
                            ['property' => 'endDate', 'label' => 'label.enddate'],
                            ['property' => 'isCompleted', 'label' => 'label.iscompleted'],
                            ['property' => 'isPinned', 'label' => 'label.ispinned'],
                            ['property' => 'tags', 'label' => 'label.tags'],
                        ],
                    ],
                    'show' => [
                        'fields' => [
                            ['property' => 'title', 'label' => 'label.title'],
                            ['property' => 'startDate', 'label' => 'label.startdate'],
                            ['property' => 'endDate', 'label' => 'label.enddate'],
                            ['property' => 'isCompleted', 'label' => 'label.iscompleted'],
                            ['property' => 'isPinned', 'label' => 'label.ispinned'],
                            ['property' => 'note', 'label' => 'label.note'],
                            ['property' => 'createdAt', 'label' => 'label.createdat'],
                            ['property' => 'updatedAt', 'label' => 'label.updatedat'],
                            ['property' => 'tags', 'label' => 'label.tags'],
                        ],
                    ],
                    'form' => [
                        'title' => 'add.task',
                        'fields' => [
                            ['property' => 'title', 'label' => 'label.title'],
                            ['property' => 'startDate', 'label' => 'label.startdate', 'type_options' => ['minutes' => self::DEFAULT_MINUTES]],
                            ['property' => 'endDate', 'label' => 'label.enddate', 'type_options' => ['minutes' => self::DEFAULT_MINUTES]],
                            ['property' => 'note', 'label' => 'label.note'],
                            ['property' => 'isPinned', 'label' => 'label.pin.task', 'help' => 'Is this task very important?'],
                            ['property' => 'isCompleted', 'label' => 'label.complete.task'],
                            ['property' => 'tags', 'label' => 'label.tags'],
                        ],
                    ],
                    'edit' => [
                        'title' => 'edit.task (#%%entity_id%%)',
                    ],
                    'new' => [
                        'fields' => [
                            '-createdAt',
                            '-updatedAt',
                        ],
                    ],
                ],
                'Tag' => [
                    'class' => 'Guham\TaskManagerBundle\Entity\Tag',
                    'label' => 'menu.tags',
                    'list' => [
                        'title' => 'label.tags',
                        'actions' => [
                            ['name' => 'new', 'label' => 'add.tag', 'icon' => 'plus'],
                        ],
                        'fields' => [
                            ['property' => 'id', 'label' => 'label.id'],
                            ['property' => 'name', 'label' => 'label.name'],
                            ['property' => 'tasks', 'label' => 'label.tasks'],
                        ],
                    ],
                    'show' => [
                        'fields' => [
                            ['property' => 'name', 'label' => 'label.name'],
                            ['property' => 'tasks', 'label' => 'label.tasks'],
                        ],
                    ],
                    'form' => [
                        'title' => 'add.tag',
                        'fields' => [
                            ['property' => 'name', 'label' => 'label.name'],
                        ],
                    ],
                    'edit' => [
                        'title' => 'edit.tag (#%%entity_id%%)',
                    ],
                ],
            ],
        ])->shouldBeCalled();

        $containerBuilder = $containerBuilderProphecy->reveal();
        $this->extension->prepend($containerBuilder);
    }

    public function testLoad()
    {
        $containerBuilderProphecy = $this->prophesize(ContainerBuilder::class);

        $parameters = [
            'guham_task_manager.title' => 'title',
        ];
        foreach ($parameters as $key => $value) {
            $containerBuilderProphecy->setParameter($key, $value)->shouldBeCalled();
        }

        $containerBuilder = $containerBuilderProphecy->reveal();
        $this->extension->load(self::DEFAULT_CONFIG, $containerBuilder);
    }
}
