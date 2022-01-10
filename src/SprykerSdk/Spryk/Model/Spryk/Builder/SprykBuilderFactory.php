<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder;

use SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\BridgeMethodsSpryk;
use SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\MethodHelper;
use SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\MethodHelperInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\ReflectionHelper;
use SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\ReflectionHelperInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Constant\ConstantSpryk;
use SprykerSdk\Spryk\Model\Spryk\Builder\CopyModule\CopyModuleSpryk;
use SprykerSdk\Spryk\Model\Spryk\Builder\DependencyProvider\DependencyProviderSpryk;
use SprykerSdk\Spryk\Model\Spryk\Builder\Method\MethodSpryk;
use SprykerSdk\Spryk\Model\Spryk\Builder\Navigation\NavigationSpryk;
use SprykerSdk\Spryk\Model\Spryk\Builder\ResourceRoute\ResourceRouteSpryk;
use SprykerSdk\Spryk\Model\Spryk\Builder\Schema\SchemaSpryk;
use SprykerSdk\Spryk\Model\Spryk\Builder\Structure\StructureSpryk;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRenderer;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\TemplateSpryk;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\UpdateYmlSpryk;
use SprykerSdk\Spryk\Model\Spryk\Builder\Transfer\TransferPropertySpryk;
use SprykerSdk\Spryk\Model\Spryk\Builder\Transfer\TransferSpryk;
use SprykerSdk\Spryk\Model\Spryk\Builder\Wrapper\WrapperSpryk;
use SprykerSdk\Spryk\Model\Spryk\Filter\FilterFactory;
use SprykerSdk\Spryk\SprykConfig;

class SprykBuilderFactory
{
    /**
     * @var \SprykerSdk\Spryk\SprykConfig
     */
    protected $config;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Filter\FilterFactory
     */
    protected $filterFactory;

    /**
     * @param \SprykerSdk\Spryk\SprykConfig $config
     * @param \SprykerSdk\Spryk\Model\Spryk\Filter\FilterFactory $filterFactory
     */
    public function __construct(SprykConfig $config, FilterFactory $filterFactory)
    {
        $this->config = $config;
        $this->filterFactory = $filterFactory;
    }

    /**
     * @return \SprykerSdk\Spryk\SprykConfig
     */
    public function getConfig(): SprykConfig
    {
        return $this->config;
    }

    /**
     * @return array<\SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface>
     */
    public function getSprykBuilder(): array
    {
        return [
            $this->createWrapperSpryk(),
            $this->createStructureSpryk(),
            $this->createTemplateSpryk(),
            $this->createUpdateYmlSpryk(),
            $this->createMethodSpryk(),
            $this->createConstantSpryk(),
            $this->createNavigationSpryk(),
            $this->createSchemaSpryk(),
            $this->createBridgeMethodsSpryk(),
            $this->createCopyModuleSpryk(),
            $this->createTransferSpryk(),
            $this->createTransferPropertySpryk(),
            $this->createResourceRouteSpryk(),
            $this->createDependencyProviderSpryk(),
        ];
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createWrapperSpryk(): SprykBuilderInterface
    {
        return new WrapperSpryk();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createStructureSpryk(): SprykBuilderInterface
    {
        return new StructureSpryk(
            $this->getConfig()->getRootDirectory(),
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createTemplateSpryk(): SprykBuilderInterface
    {
        return new TemplateSpryk(
            $this->createTemplateRenderer(),
            $this->getConfig()->getRootDirectory(),
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createUpdateYmlSpryk(): SprykBuilderInterface
    {
        return new UpdateYmlSpryk(
            $this->createTemplateRenderer(),
            $this->getConfig()->getRootDirectory(),
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createMethodSpryk(): SprykBuilderInterface
    {
        return new MethodSpryk(
            $this->createTemplateRenderer(),
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createConstantSpryk(): SprykBuilderInterface
    {
        return new ConstantSpryk();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createNavigationSpryk(): SprykBuilderInterface
    {
        return new NavigationSpryk(
            $this->getConfig()->getRootDirectory(),
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createSchemaSpryk(): SprykBuilderInterface
    {
        return new SchemaSpryk(
            $this->getConfig()->getRootDirectory(),
            $this->filterFactory->createCamelCaseFilter(),
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    public function createTemplateRenderer(): TemplateRendererInterface
    {
        return new TemplateRenderer(
            $this->getConfig()->getTemplateDirectories(),
            [$this->filterFactory->createFilterExtension()],
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createBridgeMethodsSpryk(): SprykBuilderInterface
    {
        return new BridgeMethodsSpryk(
            $this->createTemplateRenderer(),
            $this->createReflectionHelper(),
            $this->createMethodHelper(),
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createCopyModuleSpryk(): SprykBuilderInterface
    {
        return new CopyModuleSpryk(
            $this->getConfig(),
            $this->filterFactory->createDasherizeFilter(),
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createTransferSpryk(): SprykBuilderInterface
    {
        return new TransferSpryk(
            $this->getConfig()->getRootDirectory(),
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createTransferPropertySpryk(): SprykBuilderInterface
    {
        return new TransferPropertySpryk(
            $this->getConfig()->getRootDirectory(),
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createResourceRouteSpryk(): SprykBuilderInterface
    {
        return new ResourceRouteSpryk(
            $this->createTemplateRenderer(),
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createDependencyProviderSpryk(): SprykBuilderInterface
    {
        return new DependencyProviderSpryk($this->createTemplateRenderer());
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\ReflectionHelperInterface
     */
    public function createReflectionHelper(): ReflectionHelperInterface
    {
        return new ReflectionHelper();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\MethodHelperInterface
     */
    public function createMethodHelper(): MethodHelperInterface
    {
        return new MethodHelper();
    }
}
