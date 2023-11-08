<?php declare(strict_types=1);

namespace Tm\OrangeMoneyBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class OrangeMoneyBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        //$extension = $container->add('orange-money-bundle');
        //$container->add
    }
}
