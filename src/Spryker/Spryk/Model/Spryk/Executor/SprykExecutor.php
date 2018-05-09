<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Executor;

use Spryker\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface;
use Spryker\Spryk\Model\Spryk\Definition\SprykDefinition;
use Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use Spryker\Spryk\Model\Spryk\Loader\SprykLoaderInterface;
use Spryker\Spryk\Style\SprykStyleInterface;

class SprykExecutor implements SprykExecutorInterface
{
    /**
     * @var \Spryker\Spryk\Model\Spryk\Loader\SprykLoaderInterface
     */
    protected $sprykLoader;

    /**
     * @var \Spryker\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface
     */
    protected $sprykBuilderCollection;

    /**
     * @var \Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface
     */
    protected $argumentResolver;

    /**
     * @var \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface[]
     */
    protected $definitionCollection = [];

    /**
     * @var string
     */
    protected $calledSpryk;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Loader\SprykLoaderInterface $sprykLoader
     * @param \Spryker\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface $sprykBuilderCollection
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface $argumentResolver
     */
    const SPRYK_BUILDER_NAME = 'spryk';

    const ARGUMENTS = 'arguments';

    /**
     * @param \Spryker\Spryk\Model\Spryk\Loader\SprykLoaderInterface $sprykLoader
     * @param \Spryker\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface $sprykBuilderCollection
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface $argumentResolver
     */
    public function __construct(SprykLoaderInterface $sprykLoader, SprykBuilderCollectionInterface $sprykBuilderCollection, ArgumentResolverInterface $argumentResolver)
    {
        $this->sprykLoader = $sprykLoader;
        $this->sprykBuilderCollection = $sprykBuilderCollection;
        $this->argumentResolver = $argumentResolver;
    }

    /**
     * @param string $sprykName
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function execute(string $sprykName, SprykStyleInterface $style): void
    {
        $this->calledSpryk = $sprykName;
        $sprykDefinition = $this->buildDefinition($sprykName, $style);

        $this->buildSpryk($sprykDefinition, $style);
    }

    /**
     * @param string $sprykName
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    protected function buildDefinition(string $sprykName, SprykStyleInterface $style): SprykDefinitionInterface
    {
        if (!isset($this->definitionCollection[$sprykName])) {
            $sprykConfiguration = $this->sprykLoader->loadSpryk($sprykName);
            $argumentCollection = $this->argumentResolver->resolve($sprykConfiguration[static::ARGUMENTS], $sprykName, $style);

            $sprykDefinition = $this->createDefinition($sprykName, $sprykConfiguration[static::SPRYK_BUILDER_NAME]);
            $sprykDefinition->setArgumentCollection($argumentCollection);
            $sprykDefinition->setPreSpryks($this->getPreSpryks($sprykConfiguration, $style));
            $sprykDefinition->setPostSpryks($this->getPostSpryks($sprykConfiguration, $style));

            $this->definitionCollection[$sprykName] = $sprykDefinition;
        }

        return $this->definitionCollection[$sprykName];
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
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return array
     */
    protected function getPreSpryks(array $sprykConfiguration, SprykStyleInterface $style): array
    {
        $preSpryks = [];
        if (isset($sprykConfiguration['preSpryks'])) {
            foreach ($sprykConfiguration['preSpryks'] as $preSprykName) {
                if ($this->calledSpryk === $preSprykName) {
                    continue;
                }

                $preSpryks[] = $this->buildDefinition($preSprykName, $style);
            }
        }

        return $preSpryks;
    }

    /**
     * @param array $sprykConfiguration
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return array
     */
    protected function getPostSpryks(array $sprykConfiguration, SprykStyleInterface $style): array
    {
        $postSpryks = [];
        if (isset($sprykConfiguration['postSpryks'])) {
            foreach ($sprykConfiguration['postSpryks'] as $postSprykName) {
                $postSpryks[] = $this->buildDefinition($postSprykName, $style);
            }
        }

        return $postSpryks;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function buildSpryk(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $this->buildPreSpryks($sprykDefinition, $style);

        $builder = $this->sprykBuilderCollection->getBuilder($sprykDefinition);
        $builder->build($sprykDefinition);

        $this->buildPostSpryks($sprykDefinition, $style);
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function buildPreSpryks(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $preSpryks = $sprykDefinition->getPreSpryks();
        if (count($preSpryks) > 0) {
            foreach ($preSpryks as $preSprykDefinition) {
                $this->buildSpryk($preSprykDefinition, $style);
            }
        }
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function buildPostSpryks(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $postSpryks = $sprykDefinition->getPostSpryks();
        if (count($postSpryks) > 0) {
            foreach ($postSpryks as $postSprykDefinition) {
                $this->buildSpryk($postSprykDefinition, $style);
            }
        }
    }
}
