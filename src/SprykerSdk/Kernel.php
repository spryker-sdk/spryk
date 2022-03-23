<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk;

use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtender;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderPluginInterface;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * @param \Symfony\Component\Routing\RouteCollectionBuilder $routes
     *
     * @return void
     */
    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
    }

    /**
     * @param \Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $container
     *
     * @return void
     */
//    protected function configureContainer(ContainerConfigurator $container): void
//    {
//        $configDir = $this->getConfigDir();
//        $container->import($configDir . '/{packages}/*.yaml');
//        $container->import($configDir . '/{packages}/' . $this->environment . '/*.yaml');
//
//        if (is_file($configDir . '/services.yaml')) {
//            $container->import($configDir . '/services.yaml');
//            $container->import($configDir . '/{services}_' . $this->environment . '.yaml');
//        } else {
//            $container->import($configDir . '/{services}.php');
//        }
//    }

    /**
     * @return void
     */
    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader): void
    {
        $configDir = $this->getConfigDir();
        $loader->import($configDir . '/packages/framework.yaml');
        $loader->import($configDir . '/packages/' . $this->environment . '/framework.yaml');

        if (is_file($configDir . '/services.yaml')) {
            $loader->import($configDir . '/services.yaml');
            $loader->import($configDir . '/services_' . $this->environment . '.yaml');
        } else {
            $loader->import($configDir . '/services.php');
        }
    }

    /**
     * @return string
     */
    protected function getConfigDir(): string
    {
        return $this->getProjectDir() . '/config';
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new AutowireArrayParameterCompilerPass());
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

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function registerBundles(): iterable
    {
        $contents = require $this->getProjectDir() . '/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }
}
