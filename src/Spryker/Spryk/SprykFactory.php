<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk;

use Spryker\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollection;
use Spryker\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface;
use Spryker\Spryk\Model\Spryk\Builder\Method\MethodSpryk;
use Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use Spryker\Spryk\Model\Spryk\Builder\Structure\StructureSpryk;
use Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRenderer;
use Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use Spryker\Spryk\Model\Spryk\Builder\Template\TemplateSpryk;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollection;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolver;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface;
use Spryker\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilder;
use Spryker\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilderInterface;
use Spryker\Spryk\Model\Spryk\Dumper\Finder\SprykDefinitionFinder;
use Spryker\Spryk\Model\Spryk\Dumper\Finder\SprykDefinitionFinderInterface;
use Spryker\Spryk\Model\Spryk\Dumper\SprykDefinitionDumper;
use Spryker\Spryk\Model\Spryk\Dumper\SprykDefinitionDumperInterface;
use Spryker\Spryk\Model\Spryk\Executor\SprykExecutor;
use Spryker\Spryk\Model\Spryk\Executor\SprykExecutorInterface;
use Spryker\Spryk\Model\Spryk\Loader\SprykLoader;
use Spryker\Spryk\Model\Spryk\Loader\SprykLoaderInterface;

class SprykFactory
{
    /**
     * @var \Spryker\Spryk\SprykConfig|null
     */
    protected $config;

    /**
     * @return \Spryker\Spryk\Model\Spryk\Executor\SprykExecutorInterface
     */
    public function createSprykExecutor(): SprykExecutorInterface
    {
        return new SprykExecutor(
            $this->createSprykDefinitionBuilder(),
            $this->createSprykBuilderCollection()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilderInterface
     */
    public function createSprykDefinitionBuilder(): SprykDefinitionBuilderInterface
    {
        return new SprykDefinitionBuilder(
            $this->createConfigurationLoader(),
            $this->createArgumentResolver()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Loader\SprykLoaderInterface
     */
    public function createConfigurationLoader(): SprykLoaderInterface
    {
        return new SprykLoader(
            $this->getConfig()->getSprykDirectories()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface
     */
    public function createSprykBuilderCollection(): SprykBuilderCollectionInterface
    {
        $sprykBuilderCollection = new SprykBuilderCollection(
            $this->getSprykBuilder()
        );

        return $sprykBuilderCollection;
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface[]
     */
    public function getSprykBuilder(): array
    {
        return [
            $this->createStructureSpryk(),
            $this->createTemplateSpryk(),
            $this->createMethodSpryk(),
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
    public function createMethodSpryk(): SprykBuilderInterface
    {
        return new MethodSpryk(
            $this->createTemplateRenderer()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    public function createTemplateRenderer(): TemplateRendererInterface
    {
        return new TemplateRenderer(
            $this->getConfig()->getTemplateDirectories()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface
     */
    public function createArgumentResolver(): ArgumentResolverInterface
    {
        return new ArgumentResolver(
            $this->createArgumentCollection()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    public function createArgumentCollection(): ArgumentCollectionInterface
    {
        return new ArgumentCollection();
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Dumper\SprykDefinitionDumperInterface
     */
    public function createSprykDefinitionDumper(): SprykDefinitionDumperInterface
    {
        return new SprykDefinitionDumper(
            $this->createDefinitionFinder()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Dumper\Finder\SprykDefinitionFinderInterface
     */
    public function createDefinitionFinder(): SprykDefinitionFinderInterface
    {
        return new SprykDefinitionFinder(
            $this->getConfig()->getSprykDirectories()
        );
    }

    /**
     * @return \Spryker\Spryk\SprykConfig
     */
    public function getConfig()
    {
        if ($this->config === null) {
            $this->config = new SprykConfig();
        }

        return $this->config;
    }

    /**
     * @param \Spryker\Spryk\SprykConfig $config
     *
     * @return $this
     */
    public function setConfig(SprykConfig $config): SprykFactory
    {
        $this->config = $config;

        return $this;
    }
}
