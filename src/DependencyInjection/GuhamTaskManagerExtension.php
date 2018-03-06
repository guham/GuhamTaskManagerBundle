<?php

declare(strict_types=1);

namespace Guham\TaskManagerBundle\DependencyInjection;

use Guham\TaskManagerBundle\Entity\Tag;
use Guham\TaskManagerBundle\Entity\Task;
use Guham\TaskManagerBundle\Form\Type\TaskDateTimeType;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class GuhamTaskManagerExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('stof_doctrine_extensions', [
            'orm' => ['default' => ['timestampable' => true]],
        ]);

        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        $container->prependExtensionConfig('easy_admin', [
            'site_name' => 'Task Manager - Admin',
            'design' => [
                'brand_color' => '#4F805D',
                'menu' => [
                    ['label' => 'menu.homepage', 'route' => $config['homepage_route'], 'icon' => 'home'],
                    ['entity' => 'Task', 'icon' => 'tasks', 'default' => true],
                    ['entity' => 'Tag', 'icon' => 'tags'],
                ],
                'assets' => [
                    'css' => [
                        'bundles/guhamtaskmanager/css/admin.css',
                    ],
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
                    'class' => Task::class,
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
                            ['property' => 'title', 'label' => 'label.title', 'type_options' => ['empty_data' => '']],
                            ['property' => 'startDate', 'label' => 'label.startdate', 'type' => TaskDateTimeType::class],
                            ['property' => 'endDate', 'label' => 'label.enddate', 'type' => TaskDateTimeType::class],
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
                    'class' => Tag::class,
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
                            ['property' => 'name', 'label' => 'label.name', 'type_options' => ['empty_data' => '']],
                        ],
                    ],
                    'edit' => [
                        'title' => 'edit.tag (#%%entity_id%%)',
                    ],
                ],
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('guham_task_manager.homepage_route', $config['homepage_route']);
    }
}
