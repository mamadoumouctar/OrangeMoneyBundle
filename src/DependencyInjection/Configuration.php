<?php declare(strict_types=1);

namespace Tm\OrangeMoneyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('orange_money');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->scalarNode('client_id')->isRequired()->end()
            ->scalarNode('client_secret')->isRequired()->end()
            ->enumNode('environment')->defaultValue('production')->values(['sandbox', 'production'])->isRequired()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}