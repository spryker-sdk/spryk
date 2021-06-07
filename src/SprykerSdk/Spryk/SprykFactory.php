<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk;

use SprykerSdk\Spryk\Model\Spryk\ArgumentList\Builder\ArgumentListBuilder;
use SprykerSdk\Spryk\Model\Spryk\ArgumentList\Builder\ArgumentListBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\ArgumentList\Generator\ArgumentListGenerator;
use SprykerSdk\Spryk\Model\Spryk\ArgumentList\Generator\ArgumentListGeneratorInterface;
use SprykerSdk\Spryk\Model\Spryk\ArgumentList\Reader\ArgumentListReader;
use SprykerSdk\Spryk\Model\Spryk\ArgumentList\Reader\ArgumentListReaderInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollection;
use SprykerSdk\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderFactory;
use SprykerSdk\Spryk\Model\Spryk\Command\ComposerDumpAutoloadSprykHookCommand;
use SprykerSdk\Spryk\Model\Spryk\Command\ComposerReplaceGenerateSprykHookCommand;
use SprykerSdk\Spryk\Model\Spryk\Command\SprykCommandInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\ConfigurationFactory;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackFactory;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollection;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolver;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Superseder\Superseder;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Superseder\SupersederInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilder;
use SprykerSdk\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Dumper\Finder\SprykDefinitionFinder;
use SprykerSdk\Spryk\Model\Spryk\Dumper\Finder\SprykDefinitionFinderInterface;
use SprykerSdk\Spryk\Model\Spryk\Dumper\SprykDefinitionDumper;
use SprykerSdk\Spryk\Model\Spryk\Dumper\SprykDefinitionDumperInterface;
use SprykerSdk\Spryk\Model\Spryk\Executor\Configuration\SprykExecutorConfiguration;
use SprykerSdk\Spryk\Model\Spryk\Executor\Configuration\SprykExecutorConfigurationInterface;
use SprykerSdk\Spryk\Model\Spryk\Executor\SprykExecutor;
use SprykerSdk\Spryk\Model\Spryk\Executor\SprykExecutorInterface;
use SprykerSdk\Spryk\Model\Spryk\Filter\FilterFactory;
use SprykerSdk\Spryk\Style\SprykStyle;
use SprykerSdk\Spryk\Style\SprykStyleInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SprykFactory
{
    /**
     * @var \SprykerSdk\Spryk\SprykConfig|null
     */
    protected $config;

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Executor\SprykExecutorInterface
     */
    public function createSprykExecutor(): SprykExecutorInterface
    {
        return new SprykExecutor(
            $this->createSprykDefinitionBuilder(),
            $this->createSprykBuilderCollection(),
            $this->getCommandStack()
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilderInterface
     */
    public function createSprykDefinitionBuilder(): SprykDefinitionBuilderInterface
    {
        return new SprykDefinitionBuilder(
            $this->createConfigurationFactory()->createConfigurationLoader(),
            $this->createArgumentResolver(),
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\ConfigurationFactory
     */
    public function createConfigurationFactory(): ConfigurationFactory
    {
        return new ConfigurationFactory($this->getConfig());
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface
     */
    public function createSprykBuilderCollection(): SprykBuilderCollectionInterface
    {
        $sprykBuilderCollection = new SprykBuilderCollection(
            $this->createSprykBuilderFactory()->getSprykBuilder()
        );

        return $sprykBuilderCollection;
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderFactory
     */
    public function createSprykBuilderFactory(): SprykBuilderFactory
    {
        return new SprykBuilderFactory(
            $this->getConfig(),
            $this->createFilterFactory()
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterFactory
     */
    public function createFilterFactory(): FilterFactory
    {
        return new FilterFactory();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface
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
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Superseder\SupersederInterface
     */
    public function createSuperseder(): SupersederInterface
    {
        return new Superseder(
            $this->createSprykBuilderFactory()->createTemplateRenderer()
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackFactory
     */
    public function createCallbackFactory(): CallbackFactory
    {
        return new CallbackFactory();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    public function createArgumentCollection(): ArgumentCollectionInterface
    {
        return new ArgumentCollection();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Dumper\SprykDefinitionDumperInterface
     */
    public function createSprykDefinitionDumper(): SprykDefinitionDumperInterface
    {
        return new SprykDefinitionDumper(
            $this->createDefinitionFinder(),
            $this->createConfigurationFactory()->createConfigurationLoader()
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Dumper\Finder\SprykDefinitionFinderInterface
     */
    public function createDefinitionFinder(): SprykDefinitionFinderInterface
    {
        return new SprykDefinitionFinder(
            $this->getConfig()->getSprykDirectories()
        );
    }

    /**
     * @return \SprykerSdk\Spryk\SprykConfig
     */
    public function getConfig(): SprykConfig
    {
        if ($this->config === null) {
            $this->config = new SprykConfig();
        }

        return $this->config;
    }

    /**
     * @param \SprykerSdk\Spryk\SprykConfig $config
     *
     * @return $this
     */
    public function setConfig(SprykConfig $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Builder\ArgumentListBuilderInterface
     */
    public function createArgumentsListBuilder(): ArgumentListBuilderInterface
    {
        return new ArgumentListBuilder();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Generator\ArgumentListGeneratorInterface
     */
    public function createArgumentListGenerator(): ArgumentListGeneratorInterface
    {
        return new ArgumentListGenerator(
            $this->getConfig()->getArgumentListFilePath(),
            $this->createArgumentsListBuilder()
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Reader\ArgumentListReaderInterface
     */
    public function createArgumentListReader(): ArgumentListReaderInterface
    {
        return new ArgumentListReader(
            $this->getConfig()->getArgumentListFilePath(),
            $this->createArgumentsListBuilder(),
            $this->createSprykDefinitionDumper()
        );
    }

    /**
     * @param string $sprykName
     * @param string[] $includeOptionalSubSpryks
     * @param string $targetModuleName
     * @param string $dependentModuleName
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Executor\Configuration\SprykExecutorConfigurationInterface
     */
    public function createSprykExecutorConfiguration(
        string $sprykName,
        array $includeOptionalSubSpryks,
        string $targetModuleName,
        string $dependentModuleName
    ): SprykExecutorConfigurationInterface {
        return new SprykExecutorConfiguration(
            $sprykName,
            $includeOptionalSubSpryks,
            $targetModuleName,
            $dependentModuleName
        );
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return \SprykerSdk\Spryk\Style\SprykStyleInterface
     */
    public function createSprykStyle(InputInterface $input, OutputInterface $output): SprykStyleInterface
    {
        return new SprykStyle($input, $output);
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Command\SprykCommandInterface[]
     */
    public function getCommandStack(): array
    {
        return [
            $this->createComposerReplaceGenerateSprykHookCommand(),
            $this->createComposerDumpAutoloadSprykHookCommand(),
        ];
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Command\SprykCommandInterface
     */
    public function createComposerReplaceGenerateSprykHookCommand(): SprykCommandInterface
    {
        return new ComposerReplaceGenerateSprykHookCommand();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Command\SprykCommandInterface
     */
    public function createComposerDumpAutoloadSprykHookCommand(): SprykCommandInterface
    {
        return new ComposerDumpAutoloadSprykHookCommand();
    }
}
