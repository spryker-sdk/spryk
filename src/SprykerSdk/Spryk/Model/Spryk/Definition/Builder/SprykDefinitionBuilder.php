<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Builder;

use SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Model\Spryk\Executor\Configuration\SprykExecutorConfigurationInterface;
use SprykerSdk\Spryk\SprykConfig;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class SprykDefinitionBuilder implements SprykDefinitionBuilderInterface
{
    protected const SPRYK_BUILDER_NAME = 'spryk';

    protected const ARGUMENTS = 'arguments';
    protected const ARGUMENT_NAME_LAYER = 'layer';
    protected const ARGUMENT_NAME_MODE = 'mode';
    protected const ARGUMENT_NAME_MODULE = 'module';
    protected const ARGUMENT_NAME_ORGANIZATION = 'organization';
    protected const ARGUMENT_KEY_VALUE = 'value';

    protected const CONFIGURATION_KEY_PRE_SPRYKS = 'preSpryks';
    protected const CONFIGURATION_KEY_POST_SPRYKS = 'postSpryks';
    protected const CONFIGURATION_KEY_PRE_COMMANDS = 'preCommands';
    protected const CONFIGURATION_KEY_POST_COMMANDS = 'postCommands';

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface
     */
    protected $sprykLoader;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface
     */
    protected $argumentResolver;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface[]
     */
    protected $definitionCollection = [];

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface[]
     */
    protected $argumentCollectionCache = [];

    /**
     * @var string|null
     */
    protected $calledSpryk;

    /**
     * @var \SprykerSdk\Spryk\Style\SprykStyleInterface
     */
    protected $style;

    /**
     * @var string
     */
    protected $mode;

    /**
     * @var \SprykerSdk\Spryk\SprykConfig
     */
    protected $sprykConfig;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface $sprykLoader
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface $argumentResolver
     * @param \SprykerSdk\Spryk\SprykConfig $sprykConfig
     */
    public function __construct(
        SprykConfigurationLoaderInterface $sprykLoader,
        ArgumentResolverInterface $argumentResolver,
        SprykConfig $sprykConfig
    ) {
        $this->sprykLoader = $sprykLoader;
        $this->argumentResolver = $argumentResolver;
        $this->sprykConfig = $sprykConfig;
    }

    /**
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return $this
     */
    public function setStyle(SprykStyleInterface $style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * @param string $sprykName
     * @param array|null $preDefinedDefinition
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface|null $parentArgumentCollection
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function buildDefinition(
        string $sprykName,
        ?array $preDefinedDefinition = null,
        ?ArgumentCollectionInterface $parentArgumentCollection = null
    ): SprykDefinitionInterface {
        if ($this->calledSpryk === null) {
            $this->calledSpryk = $sprykName;
        }

        $this->resolveModeByOrganisation($preDefinedDefinition);
        $sprykConfiguration = $this->loadConfig($sprykName);

        $arguments = $this->mergeArguments($sprykConfiguration[static::ARGUMENTS], $preDefinedDefinition);

        if ($this->mode === null && isset($arguments[static::ARGUMENT_NAME_MODE][static::ARGUMENT_KEY_VALUE])) {
            $this->mode = $arguments[static::ARGUMENT_NAME_MODE][static::ARGUMENT_KEY_VALUE];
        }

        $argumentCollection = $this->argumentResolver->resolve(
            $arguments,
            $sprykName,
            $this->style,
            $parentArgumentCollection
        );

        $sprykDefinitionKey = sprintf('%s.%s', $sprykName, $argumentCollection->getFingerprint());
        $this->argumentCollectionCache[$sprykDefinitionKey] = $argumentCollection;

        if (!isset($this->definitionCollection[$sprykDefinitionKey])) {
            $sprykDefinition = $this->createDefinition($sprykName, $sprykConfiguration[static::SPRYK_BUILDER_NAME]);
            $this->definitionCollection[$sprykDefinitionKey] = $sprykDefinition;

            $sprykDefinition->setMode($this->getMode($sprykConfiguration));
            $sprykDefinition->setArgumentCollection($argumentCollection);
            $sprykDefinition->setSprykDefinitionKey($sprykDefinitionKey);

            $sprykDefinition->setPreCommands($this->getPreCommands($sprykConfiguration));
            $sprykDefinition->setPreSpryks($this->getPreSpryks($sprykConfiguration, $sprykDefinitionKey));
            $sprykDefinition->setPostSpryks($this->getPostSpryks($sprykConfiguration, $sprykDefinitionKey));
            $sprykDefinition->setPostCommands($this->getPostCommands($sprykConfiguration));
            $sprykDefinition->setConfig($this->getConfig($sprykConfiguration, $preDefinedDefinition));
        }

        return $this->definitionCollection[$sprykDefinitionKey];
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Executor\Configuration\SprykExecutorConfigurationInterface $sprykExecutorConfiguration
     * @param mixed[] $sprykDefinition
     *
     * @return mixed[]
     */
    public function addTargetModuleParams(
        SprykExecutorConfigurationInterface $sprykExecutorConfiguration,
        array $sprykDefinition
    ): array {
        if ($sprykExecutorConfiguration->getTargetModule()) {
            $sprykDefinition[static::ARGUMENTS][static::ARGUMENT_NAME_MODULE][static::ARGUMENT_KEY_VALUE] = $sprykExecutorConfiguration->getTargetModule();
        }

        if ($sprykExecutorConfiguration->getTargetModuleOrganization()) {
            $sprykDefinition[static::ARGUMENTS][static::ARGUMENT_NAME_ORGANIZATION][static::ARGUMENT_KEY_VALUE] = $sprykExecutorConfiguration->getTargetModuleOrganization();
        }

        if ($sprykExecutorConfiguration->getTargetModuleLayer()) {
            $sprykDefinition[static::ARGUMENTS][static::ARGUMENT_NAME_LAYER][static::ARGUMENT_KEY_VALUE] = $sprykExecutorConfiguration->getTargetModuleLayer();
        }

        return $sprykDefinition;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Executor\Configuration\SprykExecutorConfigurationInterface $sprykExecutorConfiguration
     * @param mixed[] $sprykDefinition
     *
     * @return mixed[]
     */
    public function addDependentModuleParams(
        SprykExecutorConfigurationInterface $sprykExecutorConfiguration,
        array $sprykDefinition
    ): array {
        if ($sprykExecutorConfiguration->getDependentModule()) {
            $sprykDefinition[static::ARGUMENTS][static::ARGUMENT_NAME_MODULE][static::ARGUMENT_KEY_VALUE] = $sprykExecutorConfiguration->getDependentModule();
        }

        if ($sprykExecutorConfiguration->getDependentModuleOrganization()) {
            $sprykDefinition[static::ARGUMENTS][static::ARGUMENT_NAME_ORGANIZATION][static::ARGUMENT_KEY_VALUE] = $sprykExecutorConfiguration->getDependentModuleOrganization();
        }

        if ($sprykExecutorConfiguration->getDependentModuleLayer()) {
            $sprykDefinition[static::ARGUMENTS][static::ARGUMENT_NAME_LAYER][static::ARGUMENT_KEY_VALUE] = $sprykExecutorConfiguration->getDependentModuleLayer();
        }

        return $sprykDefinition;
    }

    /**
     * @param array $arguments
     * @param array|null $preDefinedDefinition
     *
     * @return array
     */
    protected function mergeArguments(array $arguments, ?array $preDefinedDefinition = null): array
    {
        if (is_array($preDefinedDefinition) && isset($preDefinedDefinition[static::ARGUMENTS])) {
            $arguments = array_merge($preDefinedDefinition[static::ARGUMENTS], $arguments);
            $arguments = array_replace_recursive($arguments, $preDefinedDefinition[static::ARGUMENTS]);
        }

        return $arguments;
    }

    /**
     * @param string $sprykName
     * @param string $builderName
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    protected function createDefinition(string $sprykName, string $builderName): SprykDefinitionInterface
    {
        $sprykDefinition = new SprykDefinition();
        $sprykDefinition
            ->setBuilder($builderName)
            ->setSprykName($sprykName);

        return $sprykDefinition;
    }

    /**
     * @param array $sprykConfiguration
     * @param array|null $preDefinedConfiguration
     *
     * @return array
     */
    protected function getConfig(array $sprykConfiguration, ?array $preDefinedConfiguration = null): array
    {
        $configuration = [];

        if (isset($sprykConfiguration['config'])) {
            $configuration = $sprykConfiguration['config'];
        }

        if (is_array($preDefinedConfiguration)) {
            $configuration = array_merge($configuration, $preDefinedConfiguration);
        }

        return $configuration;
    }

    /**
     * @param array $sprykConfiguration
     * @param string $parentSprykDefinitionKey
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    protected function getPreSpryks(array $sprykConfiguration, string $parentSprykDefinitionKey): array
    {
        $preSpryks = [];
        if (isset($sprykConfiguration[static::CONFIGURATION_KEY_PRE_SPRYKS])) {
            $preSpryks = $this->buildPreSprykDefinitions(
                $sprykConfiguration[static::CONFIGURATION_KEY_PRE_SPRYKS],
                $parentSprykDefinitionKey
            );
        }

        return array_filter($preSpryks);
    }

    /**
     * @param array $preSpryks
     * @param string $parentSprykDefinitionKey
     *
     * @return array
     */
    protected function buildPreSprykDefinitions(array $preSpryks, string $parentSprykDefinitionKey): array
    {
        $preSprykDefinitions = [];
        foreach ($preSpryks as $preSprykName) {
            $preSprykDefinitions[] = $this->buildSubSprykDefinition($preSprykName, $parentSprykDefinitionKey);
        }

        return $preSprykDefinitions;
    }

    /**
     * @param array $sprykConfiguration
     * @param string $parentSprykDefinitionKey
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    protected function getPostSpryks(array $sprykConfiguration, string $parentSprykDefinitionKey): array
    {
        $postSpryks = [];
        if (isset($sprykConfiguration[static::CONFIGURATION_KEY_POST_SPRYKS])) {
            $postSpryks = $this->buildPostSprykDefinitions(
                $sprykConfiguration[static::CONFIGURATION_KEY_POST_SPRYKS],
                $parentSprykDefinitionKey
            );
        }

        return array_filter($postSpryks);
    }

    /**
     * @param array $postSpryks
     * @param string $parentSprykDefinitionKey
     *
     * @return array
     */
    protected function buildPostSprykDefinitions(array $postSpryks, string $parentSprykDefinitionKey): array
    {
        $postSprykDefinitions = [];
        foreach ($postSpryks as $postSprykName) {
            $postSprykDefinitions[] = $this->buildSubSprykDefinition($postSprykName, $parentSprykDefinitionKey);
        }

        return $postSprykDefinitions;
    }

    /**
     * @param string|array $sprykInfo
     * @param string $parentSprykDefinitionKey
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface|null
     */
    protected function buildSubSprykDefinition($sprykInfo, string $parentSprykDefinitionKey): ?SprykDefinitionInterface
    {
        $parentArgumentCollection = clone $this->argumentCollectionCache[$parentSprykDefinitionKey];

        if (!is_array($sprykInfo)) {
            return $this->buildDefinition($sprykInfo, [], $parentArgumentCollection);
        }

        $sprykName = array_keys($sprykInfo)[0];
        $preDefinedDefinition = $sprykInfo[$sprykName];

        return $this->buildDefinition($sprykName, $preDefinedDefinition, $parentArgumentCollection);
    }

    /**
     * @param mixed[] $sprykConfiguration
     *
     * @return string[]
     */
    protected function getPreCommands(array $sprykConfiguration): array
    {
        if (!isset($sprykConfiguration[static::CONFIGURATION_KEY_PRE_COMMANDS])) {
            return [];
        }

        return $sprykConfiguration[static::CONFIGURATION_KEY_PRE_COMMANDS];
    }

    /**
     * @param mixed[] $sprykConfiguration
     *
     * @return string[]
     */
    protected function getPostCommands(array $sprykConfiguration): array
    {
        if (!isset($sprykConfiguration[static::CONFIGURATION_KEY_POST_COMMANDS])) {
            return [];
        }

        return $sprykConfiguration[static::CONFIGURATION_KEY_POST_COMMANDS];
    }

    /**
     * @param array $sprykConfiguration
     *
     * @return string
     */
    protected function getMode(array $sprykConfiguration): string
    {
        return $sprykConfiguration[static::ARGUMENT_NAME_MODE] ?? $this->sprykConfig->getDefaultDevelopmentMode();
    }

    /**
     * @param array $sprykConfiguration
     * @param string $sprykName
     *
     * @return array
     */
    protected function resolveBothMode(array $sprykConfiguration, string $sprykName): array
    {
        $sprykDevelopmentLayer = $this->getMode($sprykConfiguration);

        if ($sprykDevelopmentLayer !== 'both') {
            return $sprykConfiguration;
        }

        $argumentCollection = $this->argumentResolver->resolve([
            static::ARGUMENT_NAME_MODE => [
                'default' => $this->mode ?? $this->sprykConfig->getDefaultDevelopmentMode(),
                'values' => [
                    SprykConfig::NAME_DEVELOPMENT_LAYER_PROJECT,
                    SprykConfig::NAME_DEVELOPMENT_LAYER_CORE,
                ],
            ],
        ], $sprykName, $this->style);

        $modeArgument = $argumentCollection->getArgument(static::ARGUMENT_NAME_MODE);

        $sprykConfiguration = $this->sprykLoader->loadSpryk($sprykName, $modeArgument->getValue());
        $this->mode = $modeArgument->getValue();

        return $sprykConfiguration;
    }

    /**
     * @param string $sprykName
     *
     * @return array
     */
    protected function loadConfig(string $sprykName): array
    {
        $sprykConfiguration = $this->sprykLoader->loadSpryk($sprykName, $this->mode);

        return $this->resolveBothMode($sprykConfiguration, $sprykName);
    }

    /**
     * @param array|null $preDefinedDefinition
     *
     * @return void
     */
    protected function resolveModeByOrganisation(?array $preDefinedDefinition = null): void
    {
        if (!isset($preDefinedDefinition[static::ARGUMENTS][static::ARGUMENT_NAME_ORGANIZATION][static::ARGUMENT_KEY_VALUE])) {
            return;
        }

        $organisation = $preDefinedDefinition[static::ARGUMENTS][static::ARGUMENT_NAME_ORGANIZATION][static::ARGUMENT_KEY_VALUE];
        if (in_array($organisation, $this->sprykConfig->getCoreNamespaces())) {
            $this->mode = SprykConfig::NAME_DEVELOPMENT_LAYER_CORE;

            return;
        }

        if (in_array($organisation, $this->sprykConfig->getProjectNamespaces())) {
            $this->mode = SprykConfig::NAME_DEVELOPMENT_LAYER_PROJECT;
        }
    }
}
