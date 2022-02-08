<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk;

use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtender;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderPluginInterface;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * @return void
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new AutowireArrayParameterCompilerPass());

//        $container->registerForAutoconfiguration(SprykConfigurationExtenderPluginInterface::class)
//            ->addTag('spry.config_extender');

        // https://bezhermoso.github.io/2014/07/27/composing-services-with-pluggable-components-via-service-tags/
//        $container->addCompilerPass(new class implements CompilerPassInterface {
//            /**
//             * @param ContainerBuilder $container
//             */
//            public function process(ContainerBuilder $container)
//            {
//                $configExtenderChain = $container->getDefinition(SprykConfigurationExtender::class);
////                $configExtenderChain->replaceArgument(0, []);
//
//                $configExtenders = $container->findTaggedServiceIds('spry.config_extender');
//
//                foreach ($configExtenders as $serviceId => $attributes) {
//                    if ($serviceId === $configExtenderChain->getClass()) {
//                        continue;
//                    }
////                    $configExtenderChain->addMethodCall('addConfigExtender', [
////                        new Definition($serviceId),
////                    ]);
//
//                    foreach ($attributes as $attr) {
//                        $configExtenderChain->addMethodCall('addConfigExtender', array(
//                            new ReferenceConfigurator($serviceId),
////                            new Definition($serviceId),
//                        ));
//                    }
//                }
//            }
//
//        });
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function process(ContainerBuilder $container): void
    {
        $configExtenderChain = $container->getDefinition(SprykConfigurationExtender::class);
        $configExtenders = $container->findTaggedServiceIds(SprykConfigurationExtenderPluginInterface::class);

        foreach ($configExtenders as $serviceId => $attributes) {
            foreach ($attributes as $attr) {
                $configExtenderChain->addMethodCall('addConfigExtender', [
                    new Definition($serviceId),
                ]);
            }
        }
    }
}
