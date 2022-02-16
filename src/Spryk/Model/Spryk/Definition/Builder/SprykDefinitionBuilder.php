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
    /**
     * @var string
     */
    protected const SPRYK_BUILDER_NAME = 'spryk';

    /**
     * @var string
     */
    protected const CONFIGURATION_KEY_PRE_SPRYKS = 'preSpryks';

    /**
     * @var string
     */
    protected const CONFIGURATION_KEY_EXCLUDED_SPRYKS = 'excludedSpryks';

    /**
     * @var string
     */
    protected const CONFIGURATION_KEY_POST_SPRYKS = 'postSpryks';

    /**
     * @var string
     */
    protected const CONFIGURATION_KEY_PRE_COMMANDS = 'preCommands';

    /**
     * @var string
     */
    protected const CONFIGURATION_KEY_POST_COMMANDS = 'postCommands';

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface
     */
    protected SprykConfigurationLoaderInterface $sprykLoader;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface
     */
    protected ArgumentResolverInterface $argumentResolver;

    /**
     * @var array<\SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface>
     */
    protected array $definitionCollection = [];

    /**
     * @var array<\SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface>
     */
    protected array $argumentCollectionCache = [];

    /**
     * @var string|null
     */
    protected ?string $calledSpryk = null;

    /**
     * @var \SprykerSdk\Spryk\Style\SprykStyleInterface
     */
    protected SprykStyleInterface $style;

    /**
     * @var string|null
     */
    protected ?string $mode = null;

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

        if (isset($preDefinedDefinition['excludedSpryks']) && !empty($preDefinedDefinition['excludedSpryks'])) {
            $sprykConfiguration['excludedSpryks'] = $preDefinedDefinition['excludedSpryks'];
        }

        $arguments = $this->mergeArguments($sprykConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS], $preDefinedDefinition);

        if ($this->mode === null && isset($arguments[SprykConfig::NAME_ARGUMENT_MODE][SprykConfig::NAME_ARGUMENT_KEY_VALUE])) {
            $this->mode = $arguments[SprykConfig::NAME_ARGUMENT_MODE][SprykConfig::NAME_ARGUMENT_KEY_VALUE];
        }

        $argumentCollection = $this->argumentResolver->resolve(
            $arguments,
            $sprykName,
            $this->style,
            $parentArgumentCollection,
        );

        $sprykDefinitionKey = sprintf('%s.%s', $sprykName, $argumentCollection->getFingerprint());
        $this->argumentCollectionCache[$sprykDefinitionKey] = $argumentCollection;

        if (!isset($this->definitionCollection[$sprykDefinitionKey])) {
            $sprykDefinition = $this->createDefinition($sprykName, $sprykConfiguration[static::SPRYK_BUILDER_NAME]);

            $this->definitionCollection[$sprykDefinitionKey] = $sprykDefinition;

            $sprykDefinition
                ->setMode($this->getMode($sprykConfiguration))
                ->setArgumentCollection($argumentCollection)
                ->setSprykDefinitionKey($sprykDefinitionKey)
                ->setPreCommands($this->getPreCommands($sprykConfiguration))
                ->setExcludedSpryks($this->getExcludedSpryks($sprykConfiguration))
                ->setPreSpryks($this->getPreSpryks($sprykConfiguration, $sprykDefinitionKey))
                ->setPostSpryks($this->getPostSpryks($sprykConfiguration, $sprykDefinitionKey))
                ->setPostCommands($this->getPostCommands($sprykConfiguration))
                ->setConfig($this->getConfig($sprykConfiguration, $preDefinedDefinition));
        }

        return $this->definitionCollection[$sprykDefinitionKey];
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Executor\Configuration\SprykExecutorConfigurationInterface $sprykExecutorConfiguration
     * @param array<mixed> $sprykConfiguration
     *
     * @return array<mixed>
     */
    public function addTargetModuleParams(
        SprykExecutorConfigurationInterface $sprykExecutorConfiguration,
        array $sprykConfiguration
    ): array {
        if ($sprykExecutorConfiguration->getTargetModule()) {
            $sprykConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS]['module'][SprykConfig::NAME_ARGUMENT_KEY_VALUE] = $sprykExecutorConfiguration->getTargetModule();
        }

        if ($sprykExecutorConfiguration->getTargetModuleOrganization()) {
            $sprykConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS][SprykConfig::NAME_ARGUMENT_ORGANIZATION][SprykConfig::NAME_ARGUMENT_KEY_VALUE] = $sprykExecutorConfiguration->getTargetModuleOrganization();
        }

        if ($sprykExecutorConfiguration->getTargetModuleLayer()) {
            $sprykConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS][SprykConfig::NAME_ARGUMENT_LAYER][SprykConfig::NAME_ARGUMENT_KEY_VALUE] = $sprykExecutorConfiguration->getTargetModuleLayer();
        }

        return $sprykConfiguration;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Executor\Configuration\SprykExecutorConfigurationInterface $sprykExecutorConfiguration
     * @param array<mixed> $sprykConfiguration
     *
     * @return array<mixed>
     */
    public function addDependentModuleParams(
        SprykExecutorConfigurationInterface $sprykExecutorConfiguration,
        array $sprykConfiguration
    ): array {
        if ($sprykExecutorConfiguration->getDependentModule()) {
            $sprykConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS]['dependentModule'][SprykConfig::NAME_ARGUMENT_KEY_VALUE] = $sprykExecutorConfiguration->getDependentModule();
        }

        if ($sprykExecutorConfiguration->getDependentModuleOrganization()) {
            $sprykConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS]['dependentModuleOrganization'][SprykConfig::NAME_ARGUMENT_KEY_VALUE] = $sprykExecutorConfiguration->getDependentModuleOrganization();
        }

        if ($sprykExecutorConfiguration->getDependentModuleLayer()) {
            $sprykConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS]['dependentModuleLayer'][SprykConfig::NAME_ARGUMENT_KEY_VALUE] = $sprykExecutorConfiguration->getDependentModuleLayer();
        }

        return $sprykConfiguration;
    }

    /**
     * @param array $arguments
     * @param array|null $preDefinedDefinition
     *
     * @return array
     */
    protected function mergeArguments(array $arguments, ?array $preDefinedDefinition = null): array
    {
        if (is_array($preDefinedDefinition) && isset($preDefinedDefinition[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS])) {
            $arguments = array_merge($preDefinedDefinition[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS], $arguments);
            $arguments = array_replace_recursive($arguments, $preDefinedDefinition[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS]);
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
     *
     * @return array<\SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition>
     */
    protected function getExcludedSpryks(array $sprykConfiguration): array
    {
        $excludedSpryks = [];

        if (isset($sprykConfiguration[static::CONFIGURATION_KEY_EXCLUDED_SPRYKS])) {
            foreach ($sprykConfiguration[static::CONFIGURATION_KEY_EXCLUDED_SPRYKS] as $sprykName) {
                $excludedSpryks[$sprykName] = true;
            }
        }

        /** @var array<\SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition> $excludedSpryks */
        $excludedSpryks = array_filter($excludedSpryks);

        return $excludedSpryks;
    }

    /**
     * @param array $sprykConfiguration
     * @param string $parentSprykDefinitionKey
     *
     * @return array<\SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition>
     */
    protected function getPreSpryks(array $sprykConfiguration, string $parentSprykDefinitionKey): array
    {
        $preSpryks = [];
        if (isset($sprykConfiguration[static::CONFIGURATION_KEY_PRE_SPRYKS])) {
            $preSpryks = $this->buildPreSprykDefinitions(
                $sprykConfiguration[static::CONFIGURATION_KEY_PRE_SPRYKS],
                $parentSprykDefinitionKey,
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
     * @return array<\SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition>
     */
    protected function getPostSpryks(array $sprykConfiguration, string $parentSprykDefinitionKey): array
    {
        $postSpryks = [];
        if (isset($sprykConfiguration[static::CONFIGURATION_KEY_POST_SPRYKS])) {
            $postSpryks = $this->buildPostSprykDefinitions(
                $sprykConfiguration[static::CONFIGURATION_KEY_POST_SPRYKS],
                $parentSprykDefinitionKey,
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
     * @param array|string $sprykInfo
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
     * @param array<mixed> $sprykConfiguration
     *
     * @return array<string>
     */
    protected function getPreCommands(array $sprykConfiguration): array
    {
        if (!isset($sprykConfiguration[static::CONFIGURATION_KEY_PRE_COMMANDS])) {
            return [];
        }

        return $sprykConfiguration[static::CONFIGURATION_KEY_PRE_COMMANDS];
    }

    /**
     * @param array<mixed> $sprykConfiguration
     *
     * @return array<string>
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
        return $sprykConfiguration[SprykConfig::NAME_ARGUMENT_MODE] ?? $this->sprykConfig->getDefaultDevelopmentMode();
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
            SprykConfig::NAME_ARGUMENT_MODE => [
                SprykConfig::NAME_ARGUMENT_KEY_DEFAULT => $this->mode ?? $this->sprykConfig->getDefaultDevelopmentMode(),
                SprykConfig::NAME_ARGUMENT_KEY_VALUES => [
                    SprykConfig::NAME_DEVELOPMENT_LAYER_PROJECT,
                    SprykConfig::NAME_DEVELOPMENT_LAYER_CORE,
                ],
            ],
        ], $sprykName, $this->style);

        $modeArgument = $argumentCollection->getArgument(SprykConfig::NAME_ARGUMENT_MODE);

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
        if (!isset($preDefinedDefinition[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS][SprykConfig::NAME_ARGUMENT_ORGANIZATION][SprykConfig::NAME_ARGUMENT_KEY_VALUE])) {
            return;
        }

        $organisation = $preDefinedDefinition[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS][SprykConfig::NAME_ARGUMENT_ORGANIZATION][SprykConfig::NAME_ARGUMENT_KEY_VALUE];
        if (in_array($organisation, $this->sprykConfig->getCoreNamespaces())) {
            $this->mode = SprykConfig::NAME_DEVELOPMENT_LAYER_CORE;

            return;
        }

        if (in_array($organisation, $this->sprykConfig->getProjectNamespaces())) {
            $this->mode = SprykConfig::NAME_DEVELOPMENT_LAYER_PROJECT;
        }
    }
}
