<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Executor;

use Jfcherng\Diff\DiffHelper;
use SprykerSdk\Spryk\Exception\SprykWrongDevelopmentLayerException;
use SprykerSdk\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Dumper\FileDumperInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Model\Spryk\Executor\Configuration\SprykExecutorConfigurationInterface;
use SprykerSdk\Spryk\SprykConfig;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class SprykExecutor implements SprykExecutorInterface
{
    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilderInterface
     */
    protected SprykDefinitionBuilderInterface $definitionBuilder;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface
     */
    protected SprykBuilderCollectionInterface $sprykBuilderCollection;

    /**
     * @var array<\SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface>
     */
    protected array $executedSpryks = [];

    /**
     * @var array<string>
     */
    protected array $includeOptionalSubSpryks = [];

    /**
     * @var string
     */
    protected string $mainSprykDefinitionMode;

    /**
     * @var array<\SprykerSdk\Spryk\Model\Spryk\Command\SprykCommandInterface>
     */
    protected array $sprykCommands;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface
     */
    protected FileResolverInterface $fileResolver;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\Dumper\FileDumperInterface
     */
    protected FileDumperInterface $fileDumper;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilderInterface $definitionBuilder
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface $sprykBuilderCollection
     * @param array<\SprykerSdk\Spryk\Model\Spryk\Command\SprykCommandInterface> $sprykCommands
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface $fileResolver
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Dumper\FileDumperInterface $fileDumper
     */
    public function __construct(
        SprykDefinitionBuilderInterface $definitionBuilder,
        SprykBuilderCollectionInterface $sprykBuilderCollection,
        array $sprykCommands,
        FileResolverInterface $fileResolver,
        FileDumperInterface $fileDumper
    ) {
        $this->definitionBuilder = $definitionBuilder;
        $this->sprykBuilderCollection = $sprykBuilderCollection;
        $this->sprykCommands = $sprykCommands;
        $this->fileResolver = $fileResolver;
        $this->fileDumper = $fileDumper;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Executor\Configuration\SprykExecutorConfigurationInterface $sprykExecutorConfiguration
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function execute(
        SprykExecutorConfigurationInterface $sprykExecutorConfiguration,
        SprykStyleInterface $style
    ): void {
        $this->definitionBuilder->setStyle($style);
        $this->includeOptionalSubSpryks = $sprykExecutorConfiguration->getIncludeOptionalSubSpryks();

        $sprykPreDefinition = [];
        $sprykPreDefinition = $this->definitionBuilder->addTargetModuleParams(
            $sprykExecutorConfiguration,
            $sprykPreDefinition,
        );
        $sprykPreDefinition = $this->definitionBuilder->addDependentModuleParams(
            $sprykExecutorConfiguration,
            $sprykPreDefinition,
        );
        $sprykDefinition = $this->definitionBuilder->buildDefinition(
            $sprykExecutorConfiguration->getSprykName(),
            $sprykPreDefinition,
        );

        $this->mainSprykDefinitionMode = $this->getSprykDefinitionMode($sprykDefinition, $style);

        $this->buildSpryk($sprykDefinition, $style);

        $this->dumpFiles();
        $this->writeFiles($style);
    }

    /**
     * @return void
     */
    protected function dumpFiles(): void
    {
        $this->fileDumper->dumpFiles($this->fileResolver->all());
    }

    /**
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function writeFiles(SprykStyleInterface $style): void
    {
        $isDryRun = $style->getInput()->getOption('dry-run');

        foreach ($this->fileResolver->all() as $resolved) {
            if ($resolved->getOriginalContent() === $resolved->getContent()) {
                continue;
            }

            if ($isDryRun) {
                // Print diff to console
                $style->writeln($resolved->getFilePath());
                $style->writeln(DiffHelper::calculate($resolved->getOriginalContent(), $resolved->getContent()));

                continue;
            }
            file_put_contents($resolved->getFilePath(), $resolved->getContent());
        }
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function buildSpryk(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        if ($sprykDefinition->getMode() !== $this->mainSprykDefinitionMode) {
            return;
        }

        $style->startSpryk($sprykDefinition);

        $this->executePreCommands($sprykDefinition, $style);
        $this->executePreSpryks($sprykDefinition, $style);
        $this->executeSpryk($sprykDefinition, $style);
        $this->executePostSpryks($sprykDefinition, $style);
        $this->executePostCommands($sprykDefinition, $style);

        $style->endSpryk($sprykDefinition);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function executePreSpryks(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $style->startPreSpryks($sprykDefinition);
        $this->buildPreSpryks($sprykDefinition, $style);
        $style->endPreSpryks($sprykDefinition);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function executeSpryk(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $builder = $this->sprykBuilderCollection->getBuilder($sprykDefinition);
        $builder->runSpryk($sprykDefinition, $style);

        $this->executedSpryks[$sprykDefinition->getSprykDefinitionKey()] = $sprykDefinition;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function executePostSpryks(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $style->startPostSpryks($sprykDefinition);
        $this->buildPostSpryks($sprykDefinition, $style);
        $style->endPostSpryks($sprykDefinition);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function executePreCommands(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        if (!$sprykDefinition->getPreCommands()) {
            return;
        }

        $style->commandsEventReport('Pre commands start');

        foreach ($sprykDefinition->getPreCommands() as $preCommandName) {
            $this->executeCommand($preCommandName, $sprykDefinition, $style);
        }

        $style->commandsEventReport('Pre commands end');
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function executePostCommands(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        if (!$sprykDefinition->getPostCommands()) {
            return;
        }

        $style->commandsEventReport('Post commands start');

        foreach ($sprykDefinition->getPostCommands() as $postCommandName) {
            $this->executeCommand($postCommandName, $sprykDefinition, $style);
        }

        $style->commandsEventReport('Post commands end');
    }

    /**
     * @param string $commandName
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function executeCommand(
        string $commandName,
        SprykDefinitionInterface $sprykDefinition,
        SprykStyleInterface $style
    ): void {
        foreach ($this->sprykCommands as $command) {
            if ($command->getName() !== $commandName) {
                continue;
            }

            $command->execute($sprykDefinition, $style);

            return;
        }
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function buildPreSpryks(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $preSpryks = $sprykDefinition->getPreSpryks();
        $excludedSpryks = $sprykDefinition->getExcludedSpryks();

        if (count($preSpryks) === 0) {
            return;
        }

        foreach ($preSpryks as $preSprykDefinition) {
            if (isset($this->executedSpryks[$preSprykDefinition->getSprykDefinitionKey()])) {
                continue;
            }
            if (isset($excludedSpryks[$preSprykDefinition->getSprykName()])) {
                continue;
            }
            $this->buildSpryk($preSprykDefinition, $style);
        }
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function buildPostSpryks(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $postSpryks = $sprykDefinition->getPostSpryks();
        $excludedSpryks = $sprykDefinition->getExcludedSpryks();

        if (count($postSpryks) === 0) {
            return;
        }

        foreach ($postSpryks as $postSprykDefinition) {
            if (!$this->shouldSubSprykBeBuild($postSprykDefinition)) {
                continue;
            }
            if (isset($excludedSpryks[$postSprykDefinition->getSprykName()])) {
                continue;
            }
            $this->buildSpryk($postSprykDefinition, $style);
        }
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    protected function shouldSubSprykBeBuild(SprykDefinitionInterface $sprykDefinition): bool
    {
        if (isset($this->executedSpryks[$sprykDefinition->getSprykDefinitionKey()])) {
            return false;
        }

        if (isset($sprykDefinition->getConfig()['isOptional']) && !in_array($sprykDefinition->getSprykName(), $this->includeOptionalSubSpryks, true)) {
            return false;
        }

        return true;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @throws \SprykerSdk\Spryk\Exception\SprykWrongDevelopmentLayerException
     *
     * @return string
     */
    protected function getSprykDefinitionMode(
        SprykDefinitionInterface $sprykDefinition,
        SprykStyleInterface $style
    ): string {
        if (!$this->isValidModes($sprykDefinition, $style)) {
            $errorMessage = '`%s` spryk support `%s` development layer only.';

            throw new SprykWrongDevelopmentLayerException(
                sprintf($errorMessage, $sprykDefinition->getSprykName(), strtoupper($sprykDefinition->getMode())),
            );
        }

        $sprykMode = $style->getInput()->getOption(SprykConfig::NAME_ARGUMENT_MODE);

        return is_string($sprykMode) ? $sprykMode : $sprykDefinition->getMode();
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return bool
     */
    protected function isValidModes(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): bool
    {
        $sprykModeArgument = $style->getInput()->getOption(SprykConfig::NAME_ARGUMENT_MODE);
        $sprykModeDefinition = $sprykDefinition->getMode();

        if ($sprykModeArgument === false || $sprykModeArgument === null) {
            return true;
        }

        return $sprykModeArgument === $sprykModeDefinition;
    }
}
