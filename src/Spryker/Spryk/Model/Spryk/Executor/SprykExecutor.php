<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Executor;

use Spryker\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\ArgumentResolverInterface;
use Spryker\Spryk\Model\Spryk\Definition\SprykDefinition;
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
        $spryk = $this->sprykLoader->loadSpryk($sprykName);

        $sprykDefinition = new SprykDefinition();
        $sprykDefinition
            ->setBuilder($spryk['spryk'])
            ->setSprykName($sprykName);

        $argumentCollection = $this->argumentResolver->resolve($spryk['arguments'], $style);
        $sprykDefinition->setArgumentCollection($argumentCollection);

        if (isset($spryk['preSpryks'])) {
            foreach ($spryk['preSpryks'] as $sprykName) {
                $this->execute($sprykName, $style);
            }
        }

        $this->definitionCollection[$sprykDefinition->getBuilder()] = $sprykDefinition;

        if (isset($spryk['postSpryks'])) {
            foreach ($spryk['postSpryks'] as $sprykName) {
                $this->execute($sprykName, $style);
            }
        }

        $this->runBuildProcess($this->definitionCollection);
    }

    /**
     * @return void
     */
    protected function buildDefinition(string $sprykName, SprykStyleInterface $style)
    {
        $sprykConfiguration = $this->sprykLoader->loadSpryk($sprykName);
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface[] $definitionCollection
     *
     * @return void
     */
    private function runBuildProcess(array $definitionCollection)
    {
        foreach ($definitionCollection as $sprykDefinition) {
            $builder = $this->sprykBuilderCollection->getBuilder($sprykDefinition);
            $builder->build($sprykDefinition);
        }

//        if ($builder->shouldBuild($sprykDefinition)) {
//        }
    }
}
