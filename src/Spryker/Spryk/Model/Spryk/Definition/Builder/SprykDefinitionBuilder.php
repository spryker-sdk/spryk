<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Builder;

use Spryker\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface;
use Spryker\Spryk\Model\Spryk\Definition\SprykDefinition;
use Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use Spryker\Spryk\Style\SprykStyleInterface;

class SprykDefinitionBuilder implements SprykDefinitionBuilderInterface
{
    public const SPRYK_BUILDER_NAME = 'spryk';
    public const ARGUMENTS = 'arguments';

    protected const NAME_SPRYK_CONFIG_MODE = 'mode';

    /**
     * @var \Spryker\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface
     */
    protected $sprykLoader;

    /**
     * @var \Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface
     */
    protected $argumentResolver;

    /**
     * @var \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface[]
     */
    protected $definitionCollection = [];

    /**
     * @var string|null
     */
    protected $calledSpryk;

    /**
     * @var \Spryker\Spryk\Style\SprykStyleInterface
     */
    protected $style;

    /**
     * @var string
     */
    protected $mode;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface $sprykLoader
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface $argumentResolver
     */
    public function __construct(SprykConfigurationLoaderInterface $sprykLoader, ArgumentResolverInterface $argumentResolver)
    {
        $this->sprykLoader = $sprykLoader;
        $this->argumentResolver = $argumentResolver;
    }

    /**
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilderInterface
     */
    public function setStyle(SprykStyleInterface $style): SprykDefinitionBuilderInterface
    {
        $this->style = $style;

        return $this;
    }

    /**
     * @param string $sprykName
     * @param array|null $preDefinedDefinition
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface|null
     */
    public function buildDefinition(string $sprykName, ?array $preDefinedDefinition = null): ?SprykDefinitionInterface
    {
        if ($this->calledSpryk === null) {
            $this->calledSpryk = $sprykName;
        }

        if (!isset($this->definitionCollection[$sprykName])) {
            $sprykConfiguration = $this->loadConfig($sprykName);

            if ($sprykConfiguration === []) {
                return null;
            }

            $arguments = $this->mergeArguments($sprykConfiguration[static::ARGUMENTS], $preDefinedDefinition);
            $argumentCollection = $this->argumentResolver->resolve($arguments, $sprykName, $this->style);

            $sprykDefinition = $this->createDefinition($sprykName, $sprykConfiguration[static::SPRYK_BUILDER_NAME]);
            $this->definitionCollection[$sprykName] = $sprykDefinition;

            $sprykDefinition->setMode($this->getMode($sprykConfiguration));
            $sprykDefinition->setArgumentCollection($argumentCollection);

            $sprykDefinition->setPreSpryks($this->getPreSpryks($sprykConfiguration));
            $sprykDefinition->setPostSpryks($this->getPostSpryks($sprykConfiguration));
            $sprykDefinition->setConfig($this->getConfig($sprykConfiguration, $preDefinedDefinition));
        }

        return $this->definitionCollection[$sprykName];
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
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
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
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    protected function getPreSpryks(array $sprykConfiguration): array
    {
        $preSpryks = [];
        if (isset($sprykConfiguration['preSpryks'])) {
            $preSpryks = $this->buildPreSprykDefinitions($sprykConfiguration['preSpryks']);
        }

        return array_filter($preSpryks);
    }

    /**
     * @param array $preSpryks
     *
     * @return array
     */
    protected function buildPreSprykDefinitions(array $preSpryks): array
    {
        $preSprykDefinitions = [];
        foreach ($preSpryks as $preSprykName) {
            if ($this->calledSpryk === $preSprykName) {
                $preSprykDefinitions[] = $this->definitionCollection[$this->calledSpryk];
                continue;
            }

            $preSprykDefinitions[] = $this->buildSubSprykDefinition($preSprykName);
        }

        return $preSprykDefinitions;
    }

    /**
     * @param array $sprykConfiguration
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    protected function getPostSpryks(array $sprykConfiguration): array
    {
        $postSpryks = [];
        if (isset($sprykConfiguration['postSpryks'])) {
            $postSpryks = $this->buildPostSprykDefinitions($sprykConfiguration['postSpryks']);
        }

        return array_filter($postSpryks);
    }

    /**
     * @param array $postSpryks
     *
     * @return array
     */
    protected function buildPostSprykDefinitions(array $postSpryks): array
    {
        $postSprykDefinitions = [];
        foreach ($postSpryks as $postSprykName) {
            $postSprykDefinitions[] = $this->buildSubSprykDefinition($postSprykName);
        }

        return $postSprykDefinitions;
    }

    /**
     * @param string|array $sprykInfo
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface|null
     */
    protected function buildSubSprykDefinition($sprykInfo): ?SprykDefinitionInterface
    {
        if (!is_array($sprykInfo)) {
            return $this->buildDefinition($sprykInfo);
        }

        $sprykName = array_keys($sprykInfo)[0];
        $preDefinedDefinition = $sprykInfo[$sprykName];

        return $this->buildDefinition($sprykName, $preDefinedDefinition);
    }

    /**
     * @param array $sprykConfiguration
     *
     * @return string
     */
    protected function getMode(array $sprykConfiguration): string
    {
        return $sprykConfiguration[static::NAME_SPRYK_CONFIG_MODE];
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
            static::NAME_SPRYK_CONFIG_MODE => [
                'default' => 'core',
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
    protected function loadConfig(string $sprykName): array
    {
        $sprykConfiguration = $this->sprykLoader->loadSpryk($sprykName, $this->mode);

        return $this->resolveBothMode($sprykConfiguration, $sprykName);
    }
}
