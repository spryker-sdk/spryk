<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk;

use Spryker\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollection;
use Spryker\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface;
use Spryker\Spryk\Model\Spryk\Builder\SprykBuilderFactory;
use Spryker\Spryk\Model\Spryk\Configuration\ConfigurationFactory;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackFactory;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollection;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolver;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Superseder\Superseder;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Superseder\SupersederInterface;
use Spryker\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilder;
use Spryker\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilderInterface;
use Spryker\Spryk\Model\Spryk\Dumper\Finder\SprykDefinitionFinder;
use Spryker\Spryk\Model\Spryk\Dumper\Finder\SprykDefinitionFinderInterface;
use Spryker\Spryk\Model\Spryk\Dumper\SprykDefinitionDumper;
use Spryker\Spryk\Model\Spryk\Dumper\SprykDefinitionDumperInterface;
use Spryker\Spryk\Model\Spryk\Executor\SprykExecutor;
use Spryker\Spryk\Model\Spryk\Executor\SprykExecutorInterface;

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
            $this->createConfigurationFactory()->createConfigurationLoader(),
            $this->createArgumentResolver()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Configuration\ConfigurationFactory
     */
    public function createConfigurationFactory(): ConfigurationFactory
    {
        return new ConfigurationFactory($this->getConfig());
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface
     */
    public function createSprykBuilderCollection(): SprykBuilderCollectionInterface
    {
        $sprykBuilderCollection = new SprykBuilderCollection(
            $this->createSprykBuilderFactory()->getSprykBuilder()
        );

        return $sprykBuilderCollection;
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderFactory
     */
    public function createSprykBuilderFactory(): SprykBuilderFactory
    {
        return new SprykBuilderFactory(
            $this->getConfig()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface
     */
    public function createArgumentResolver(): ArgumentResolverInterface
    {
        return new ArgumentResolver(
            $this->createArgumentCollection(),
            $this->createSuperseder(),
            $this->createCallbackFactory()->createCallbackArgumentResolver()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Superseder\SupersederInterface
     */
    public function createSuperseder(): SupersederInterface
    {
        return new Superseder();
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackFactory
     */
    public function createCallbackFactory()
    {
        return new CallbackFactory();
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
            $this->createDefinitionFinder(),
            $this->createConfigurationFactory()->createConfigurationLoader()
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
    public function setConfig(SprykConfig $config): self
    {
        $this->config = $config;

        return $this;
    }
}
