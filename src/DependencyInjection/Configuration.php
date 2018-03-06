<?php

declare(strict_types=1);

namespace Guham\TaskManagerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('guham_task_manager');

        $rootNode
            ->children()
                ->scalarNode('homepage_route')
                    ->info('The homepage route.')
                    ->cannotBeEmpty()
                    ->defaultValue('/')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
