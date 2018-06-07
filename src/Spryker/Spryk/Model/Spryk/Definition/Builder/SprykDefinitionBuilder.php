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
    const SPRYK_BUILDER_NAME = 'spryk';
    const ARGUMENTS = 'arguments';

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
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function buildDefinition(string $sprykName, ?array $preDefinedDefinition = null): SprykDefinitionInterface
    {
        if ($this->calledSpryk === null) {
            $this->calledSpryk = $sprykName;
        }

        if (!isset($this->definitionCollection[$sprykName])) {
            $sprykConfiguration = $this->sprykLoader->loadSpryk($sprykName);
            $arguments = $this->mergeArguments($sprykConfiguration[static::ARGUMENTS], $preDefinedDefinition);
            $argumentCollection = $this->argumentResolver->resolve($arguments, $sprykName, $this->style);

            $sprykDefinition = $this->createDefinition($sprykName, $sprykConfiguration[static::SPRYK_BUILDER_NAME]);
            $this->definitionCollection[$sprykName] = $sprykDefinition;

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
        if ($preDefinedDefinition && isset($preDefinedDefinition[static::ARGUMENTS])) {
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

        if ($preDefinedConfiguration) {
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
            foreach ($sprykConfiguration['preSpryks'] as $preSprykName) {
                if ($this->calledSpryk === $preSprykName) {
                    $preSpryks[] = $this->definitionCollection[$this->calledSpryk];
                    continue;
                }

//                $preSpryks[] = $this->buildDefinition($preSprykName);

                if (!is_array($preSprykName)) {
                    $preSpryks[] = $this->buildDefinition($preSprykName);

                    continue;
                }

                $sprykName = array_keys($preSprykName)[0];
                $preDefinedDefinition = $preSprykName[$sprykName];

                $preSpryks[] = $this->buildDefinition($sprykName, $preDefinedDefinition);
            }
        }

        return $preSpryks;
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
            foreach ($sprykConfiguration['postSpryks'] as $postSprykName) {
                if (!is_array($postSprykName)) {
                    $postSpryks[] = $this->buildDefinition($postSprykName);

                    continue;
                }

                $sprykName = array_keys($postSprykName)[0];
                $preDefinedDefinition = $postSprykName[$sprykName];

                $postSpryks[] = $this->buildDefinition($sprykName, $preDefinedDefinition);
            }
        }

        return $postSpryks;
    }
}
