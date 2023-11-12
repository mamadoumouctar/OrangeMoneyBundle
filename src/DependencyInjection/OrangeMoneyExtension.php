<?php declare(strict_types=1);

namespace Tm\OrangeMoneyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class OrangeMoneyExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__, 2) . '/config'));
        $loader->load('services.yaml');
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $container->setParameter('mamadou.orange_money.client_id', $config['client_id']);
        $container->setParameter('mamadou.orange_money.client_secret', $config['client_secret']);
        $container->setParameter('mamadou.orange_money.environment', $config['environment']);
        $container->setParameter('mamadou.orange_money.base',
            $config['environment'] == 'production' ? 'https://api.orange-sonatel.com' : 'https://api.sandbox.orange-sonatel.com');
        //dd($container->getParameterBag()->all());
    }
}
