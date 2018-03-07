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
                ->arrayNode('entities')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('Task')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                    ->defaultValue('')
                                    ->validate()
                                        ->ifTrue(function ($v) { return !\class_exists($v); })
                                        ->thenInvalid('The class %s does not exist.')
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('Tag')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                    ->defaultValue('')
                                    ->validate()
                                        ->ifTrue(function ($v) { return !\class_exists($v); })
                                        ->thenInvalid('The class %s does not exist.')
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
