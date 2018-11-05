<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder;

use Spryker\Spryk\Model\Spryk\Builder\Bridge\BridgeMethodsSpryk;
use Spryker\Spryk\Model\Spryk\Builder\Bridge\Reflection\MethodHelper;
use Spryker\Spryk\Model\Spryk\Builder\Bridge\Reflection\MethodHelperInterface;
use Spryker\Spryk\Model\Spryk\Builder\Bridge\Reflection\ReflectionHelper;
use Spryker\Spryk\Model\Spryk\Builder\Bridge\Reflection\ReflectionHelperInterface;
use Spryker\Spryk\Model\Spryk\Builder\Constant\ConstantSpryk;
use Spryker\Spryk\Model\Spryk\Builder\Method\MethodSpryk;
use Spryker\Spryk\Model\Spryk\Builder\Navigation\NavigationSpryk;
use Spryker\Spryk\Model\Spryk\Builder\Schema\SchemaSpryk;
use Spryker\Spryk\Model\Spryk\Builder\Structure\StructureSpryk;
use Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRenderer;
use Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use Spryker\Spryk\Model\Spryk\Builder\Template\TemplateSpryk;
use Spryker\Spryk\Model\Spryk\Builder\Template\UpdateYmlSpryk;
use Spryker\Spryk\Model\Spryk\Filter\FilterFactory;
use Spryker\Spryk\SprykConfig;

class SprykBuilderFactory
{
    /**
     * @var \Spryker\Spryk\SprykConfig
     */
    protected $config;

    /**
     * @var \Spryker\Spryk\Model\Spryk\Filter\FilterFactory
     */
    protected $filterFactory;

    /**
     * @param \Spryker\Spryk\SprykConfig $config
     * @param \Spryker\Spryk\Model\Spryk\Filter\FilterFactory $filterFactory
     */
    public function __construct(SprykConfig $config, FilterFactory $filterFactory)
    {
        $this->config = $config;
        $this->filterFactory = $filterFactory;
    }

    /**
     * @return \Spryker\Spryk\SprykConfig
     */
    public function getConfig(): SprykConfig
    {
        return $this->config;
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface[]
     */
    public function getSprykBuilder(): array
    {
        return [
            $this->createStructureSpryk(),
            $this->createTemplateSpryk(),
            $this->createUpdateYmlSpryk(),
            $this->createMethodSpryk(),
            $this->createConstantSpryk(),
            $this->createNavigationSpryk(),
            $this->createSchemaSpryk(),
            $this->createBridgeMethodsSpryk(),
        ];
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createStructureSpryk(): SprykBuilderInterface
    {
        return new StructureSpryk(
            $this->getConfig()->getRootDirectory()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createTemplateSpryk(): SprykBuilderInterface
    {
        return new TemplateSpryk(
            $this->createTemplateRenderer(),
            $this->getConfig()->getRootDirectory()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createUpdateYmlSpryk(): SprykBuilderInterface
    {
        return new UpdateYmlSpryk(
            $this->createTemplateRenderer(),
            $this->getConfig()->getRootDirectory()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createMethodSpryk(): SprykBuilderInterface
    {
        return new MethodSpryk(
            $this->createTemplateRenderer()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createConstantSpryk(): SprykBuilderInterface
    {
        return new ConstantSpryk();
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createNavigationSpryk(): SprykBuilderInterface
    {
        return new NavigationSpryk(
            $this->getConfig()->getRootDirectory()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createSchemaSpryk(): SprykBuilderInterface
    {
        return new SchemaSpryk(
            $this->getConfig()->getRootDirectory(),
            $this->filterFactory->createCamelCaseFilter()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    public function createTemplateRenderer(): TemplateRendererInterface
    {
        return new TemplateRenderer(
            $this->getConfig()->getTemplateDirectories(),
            [$this->filterFactory->createFilterExtension()]
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function createBridgeMethodsSpryk(): SprykBuilderInterface
    {
        return new BridgeMethodsSpryk(
            $this->createTemplateRenderer(),
            $this->createReflectionHelper(),
            $this->createMethodHelper()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\Bridge\Reflection\ReflectionHelperInterface
     */
    public function createReflectionHelper(): ReflectionHelperInterface
    {
        return new ReflectionHelper();
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\Bridge\Reflection\MethodHelperInterface
     */
    public function createMethodHelper(): MethodHelperInterface
    {
        return new MethodHelper();
    }
}
