<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Builder;

use SprykerSdk\Spryk\Exception\SprykWrongDevelopmentLayerException;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class SprykDefinitionBuilder implements SprykDefinitionBuilderInterface
{
    public const SPRYK_BUILDER_NAME = 'spryk';
    public const ARGUMENTS = 'arguments';

    protected const NAME_SPRYK_CONFIG_MODE = 'mode';

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
     * @var string
     */
    protected $defaultDevelopmentMode;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface $sprykLoader
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface $argumentResolver
     * @param string $defaultDevelopmentMode
     */
    public function __construct(
        SprykConfigurationLoaderInterface $sprykLoader,
        ArgumentResolverInterface $argumentResolver,
        string $defaultDevelopmentMode
    ) {
        $this->sprykLoader = $sprykLoader;
        $this->argumentResolver = $argumentResolver;
        $this->defaultDevelopmentMode = $defaultDevelopmentMode;
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
     * @param string|null $currentMode
     * @param array|null $preDefinedDefinition
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function buildDefinition(string $sprykName, ?string $currentMode = null, ?array $preDefinedDefinition = null): SprykDefinitionInterface
    {
        if ($this->calledSpryk === null) {
            $this->calledSpryk = $sprykName;
        }

        if (!isset($this->definitionCollection[$sprykName])) {
            $sprykConfiguration = $this->loadConfig($sprykName, $currentMode);

//            $this->validateSprykCanBeExecutedInMode($sprykName, $sprykConfiguration, $currentMode);

            $arguments = $this->mergeArguments($sprykConfiguration[static::ARGUMENTS], $preDefinedDefinition);

            if ($this->mode === null && isset($arguments['mode']['value'])) {
                $this->mode = $arguments['mode']['value'];
            }


            $argumentCollection = $this->argumentResolver->resolve($arguments, $sprykName, $this->style);

            $sprykDefinition = $this->createDefinition($sprykName, $sprykConfiguration[static::SPRYK_BUILDER_NAME]);
            $this->definitionCollection[$sprykName] = $sprykDefinition;

            $sprykDefinition->setMode($this->getMode($sprykConfiguration));
            $sprykDefinition->setArgumentCollection($argumentCollection);

            $sprykDefinition->setPreSpryks($this->getPreSpryks($sprykConfiguration, $currentMode));
            $sprykDefinition->setPostSpryks($this->getPostSpryks($sprykConfiguration, $currentMode));
            $sprykDefinition->setConfig($this->getConfig($sprykConfiguration, $preDefinedDefinition));
        }

        return $this->definitionCollection[$sprykName];
    }

    /**
     * @param string $sprykName
     * @param array $sprykConfiguration
     * @param string $mode
     *
     * @return void
     * @throws SprykWrongDevelopmentLayerException
     *
     */
    protected function validateSprykCanBeExecutedInMode(string $sprykName, array $sprykConfiguration, string $mode)
    {
        $sprykModes = explode('|', $sprykConfiguration['mode']);

        if (!in_array($mode, $sprykModes)) {
            throw new SprykWrongDevelopmentLayerException(sprintf(
                'Current spryk "%s" can only be executed in the mode "%s", current mode is "%s"',
                $sprykName,
                implode(', ', $sprykModes),
                $mode
            ));
        }
    }

    /**
     * @param array $arguments
     * @param array|null $preDefinedDefinition
     *
     * @return array
     */
    protected function mergeArguments(array $arguments, ?array $preDefinedDefinition = null)
    {
        if (is_array($preDefinedDefinition) && isset($preDefinedDefinition[static::ARGUMENTS])) {
            $arguments = array_merge($arguments, $preDefinedDefinition[static::ARGUMENTS]);
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
     * @param string $currentMode
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    protected function getPreSpryks(array $sprykConfiguration, $currentMode): array
    {
        $preSpryks = [];
        if (isset($sprykConfiguration['preSpryks'])) {
            $preSpryks = $this->buildPreSprykDefinitions($sprykConfiguration['preSpryks'], $currentMode);
        }

        return array_filter($preSpryks);
    }

    /**
     * @param array $preSpryks
     * @param string $currentMode
     *
     * @return array
     */
    protected function buildPreSprykDefinitions(array $preSpryks, $currentMode): array
    {
        $preSprykDefinitions = [];
        foreach ($preSpryks as $preSprykName) {
            if ($this->calledSpryk === $preSprykName) {
                $preSprykDefinitions[] = $this->definitionCollection[$this->calledSpryk];
                continue;
            }

            $preSprykDefinitions[] = $this->buildSubSprykDefinition($preSprykName, $currentMode);
        }

        return $preSprykDefinitions;
    }

    /**
     * @param array $sprykConfiguration
     * @param string $currentMode
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    protected function getPostSpryks(array $sprykConfiguration, string $currentMode): array
    {
        $postSpryks = [];
        if (isset($sprykConfiguration['postSpryks'])) {
            $postSpryks = $this->buildPostSprykDefinitions($sprykConfiguration['postSpryks'], $currentMode);
        }

        return array_filter($postSpryks);
    }

    /**
     * @param array $postSpryks
     * @param string $currentMode
     *
     * @return array
     */
    protected function buildPostSprykDefinitions(array $postSpryks, $currentMode): array
    {
        $postSprykDefinitions = [];
        foreach ($postSpryks as $postSprykName) {
            $postSprykDefinitions[] = $this->buildSubSprykDefinition($postSprykName, $currentMode);
        }

        return $postSprykDefinitions;
    }

    /**
     * @param string|array $sprykInfo
     * @param string $currentMode
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface|null
     */
    protected function buildSubSprykDefinition($sprykInfo, $currentMode): ?SprykDefinitionInterface
    {
        if (!is_array($sprykInfo)) {
            return $this->buildDefinition($sprykInfo, $currentMode);
        }

        $sprykName = array_keys($sprykInfo)[0];
        $preDefinedDefinition = $sprykInfo[$sprykName];

        return $this->buildDefinition($sprykName, $currentMode, $preDefinedDefinition);
    }

    /**
     * @param array $sprykConfiguration
     *
     * @return array
     */
    protected function getMode(array $sprykConfiguration): array
    {
        return $sprykConfiguration[static::NAME_SPRYK_CONFIG_MODE] ? explode('|', $sprykConfiguration[static::NAME_SPRYK_CONFIG_MODE]) : [$this->defaultDevelopmentMode];
    }

    /**
     * @param array $sprykConfiguration
     * @param string $sprykName
     *
     * @return array
     */
    protected function resolveAllMode(array $sprykConfiguration, string $sprykName): array
    {
        $sprykDevelopmentLayer = $this->getMode($sprykConfiguration);

        if (!in_array('all', $sprykDevelopmentLayer)) {
            return $sprykConfiguration;
        }

        $argumentCollection = $this->argumentResolver->resolve([
            static::NAME_SPRYK_CONFIG_MODE => [
                'default' => $this->mode ?? $this->defaultDevelopmentMode,
            ],
        ], $sprykName, $this->style);

        $modeArgument = $argumentCollection->getArgument(static::NAME_SPRYK_CONFIG_MODE);

        $sprykConfiguration = $this->sprykLoader->loadSpryk($sprykName, $modeArgument->getValue());
        $this->mode = $modeArgument->getValue();

        return $sprykConfiguration;
    }

    /**
     * @param string $sprykName
     *
     * @return array
     */
    protected function loadConfig(string $sprykName, ?string $currentMode): array
    {
        $sprykConfiguration = $this->sprykLoader->loadSpryk($sprykName, $currentMode ?? $this->defaultDevelopmentMode);

        return $this->resolveAllMode($sprykConfiguration, $sprykName);
    }
}
