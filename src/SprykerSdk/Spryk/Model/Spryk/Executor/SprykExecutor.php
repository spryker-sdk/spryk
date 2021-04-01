<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Executor;

use SprykerSdk\Spryk\Exception\SprykWrongDevelopmentLayerException;
use SprykerSdk\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilder;
use SprykerSdk\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class SprykExecutor implements SprykExecutorInterface
{
    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilderInterface
     */
    protected $definitionBuilder;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface
     */
    protected $sprykBuilderCollection;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface[]
     */
    protected $executedSpryks = [];

    /**
     * @var string[]
     */
    protected $includeOptionalSubSpryks = [];

    /**
     * @var string
     */
    protected $mainSprykDefinitionMode;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilderInterface $definitionBuilder
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface $sprykBuilderCollection
     */
    public function __construct(SprykDefinitionBuilderInterface $definitionBuilder, SprykBuilderCollectionInterface $sprykBuilderCollection)
    {
        $this->definitionBuilder = $definitionBuilder;
        $this->sprykBuilderCollection = $sprykBuilderCollection;
    }

    /**
     * @param string $sprykName
     * @param string[] $includeOptionalSubSpryks
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     * @param string|null $targetModuleName
     * @param string|null $dependentModuleName
     *
     * @return void
     */
    public function execute(
        string $sprykName,
        array $includeOptionalSubSpryks,
        SprykStyleInterface $style,
        ?string $targetModuleName,
        ?string $dependentModuleName
    ): void {
        $this->definitionBuilder->setStyle($style);
        $this->includeOptionalSubSpryks = $includeOptionalSubSpryks;

        $sprykPreDefinition = [];
        $sprykPreDefinition = $this->addTargetModuleParams($sprykPreDefinition, $targetModuleName);
        $sprykPreDefinition = $this->addDependentModuleParams($sprykPreDefinition, $dependentModuleName);

        $sprykDefinition = $this->definitionBuilder->buildDefinition($sprykName, $sprykPreDefinition);

        $this->mainSprykDefinitionMode = $this->getSprykDefinitionMode($sprykDefinition, $style);

        $this->buildSpryk($sprykDefinition, $style);
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

        $this->executePreSpryks($sprykDefinition, $style);
        $this->executeSpryk($sprykDefinition, $style);
        $this->executePostSpryks($sprykDefinition, $style);

        $style->endSpryk($sprykDefinition);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function executePreSpryks(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style)
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
    protected function executeSpryk(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style)
    {
        $builder = $this->sprykBuilderCollection->getBuilder($sprykDefinition);

        if ($builder->shouldBuild($sprykDefinition)) {
            $builder->build($sprykDefinition, $style);
        }

        $this->executedSpryks[$sprykDefinition->getSprykName()] = $sprykDefinition;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function executePostSpryks(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style)
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
    protected function buildPreSpryks(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $preSpryks = $sprykDefinition->getPreSpryks();
        if (count($preSpryks) === 0) {
            return;
        }

        foreach ($preSpryks as $preSprykDefinition) {
            if (isset($this->executedSpryks[$preSprykDefinition->getSprykName()])) {
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
        if (count($postSpryks) === 0) {
            return;
        }

        foreach ($postSpryks as $postSprykDefinition) {
            if (!$this->shouldSubSprykBeBuild($postSprykDefinition)) {
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
        if (isset($this->executedSpryks[$sprykDefinition->getSprykName()])) {
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
    protected function getSprykDefinitionMode(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): string
    {
        if (!$this->isValidModes($sprykDefinition, $style)) {
            $errorMessage = '`%s` spryk support `%s` development layer only.';

            throw new SprykWrongDevelopmentLayerException(
                sprintf($errorMessage, $sprykDefinition->getSprykName(), strtoupper($sprykDefinition->getMode()))
            );
        }

        $sprykMode = $style->getInput()->getOption('mode');

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
        $sprykModeArgument = $style->getInput()->getOption('mode');
        $sprykModeDefinition = $sprykDefinition->getMode();

        if ($sprykModeArgument === false || $sprykModeArgument === null) {
            return true;
        }

        return $sprykModeArgument === $sprykModeDefinition;
    }

    /**
     * @param array $sprykPreDefinition
     * @param string|null $targetModuleName
     *
     * @return array
     */
    protected function addTargetModuleParams(array $sprykPreDefinition, ?string $targetModuleName): array
    {
        if (!$targetModuleName) {
            return $sprykPreDefinition;
        }

        $explodedName = explode('.', $targetModuleName);
        if (count($explodedName) === 1) {
            $sprykPreDefinition[SprykDefinitionBuilder::ARGUMENTS]['module']['value'] = $explodedName[0];
        }
        if (count($explodedName) === 2) {
            $sprykPreDefinition[SprykDefinitionBuilder::ARGUMENTS]['organization']['value'] = $explodedName[0];
            $sprykPreDefinition[SprykDefinitionBuilder::ARGUMENTS]['module']['value'] = $explodedName[1];
        }
        if (count($explodedName) === 3) {
            $sprykPreDefinition[SprykDefinitionBuilder::ARGUMENTS]['organization']['value'] = $explodedName[0];
            $sprykPreDefinition[SprykDefinitionBuilder::ARGUMENTS]['module']['value'] = $explodedName[1];
            $sprykPreDefinition[SprykDefinitionBuilder::ARGUMENTS]['layer']['value'] = $explodedName[2];
        }

        return $sprykPreDefinition;
    }

    /**
     * @param array $sprykPreDefinition
     * @param string|null $dependentModuleName
     *
     * @return array
     */
    protected function addDependentModuleParams(array $sprykPreDefinition, ?string $dependentModuleName): array
    {
        if (!$dependentModuleName) {
            return $sprykPreDefinition;
        }

        $explodedName = explode('.', $dependentModuleName);
        if (count($explodedName) === 1) {
            $sprykPreDefinition[SprykDefinitionBuilder::ARGUMENTS]['dependentModule']['value'] = $explodedName[0];
        }
        if (count($explodedName) === 2) {
            $sprykPreDefinition[SprykDefinitionBuilder::ARGUMENTS]['dependentModuleOrganization']['value'] = $explodedName[0];
            $sprykPreDefinition[SprykDefinitionBuilder::ARGUMENTS]['dependentModule']['value'] = $explodedName[1];
        }
        if (count($explodedName) === 3) {
            $sprykPreDefinition[SprykDefinitionBuilder::ARGUMENTS]['dependentModuleOrganization']['value'] = $explodedName[0];
            $sprykPreDefinition[SprykDefinitionBuilder::ARGUMENTS]['dependentModule']['value'] = $explodedName[1];
            $sprykPreDefinition[SprykDefinitionBuilder::ARGUMENTS]['dependentModuleLayer']['value'] = $explodedName[2];
        }

        return $sprykPreDefinition;
    }
}
