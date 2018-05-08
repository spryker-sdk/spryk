<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder\Collection;

use Spryker\Spryk\Exception\BuilderNotFoundException;
use Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;

class SprykBuilderCollection implements SprykBuilderCollectionInterface
{
    /**
     * @var \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface[]
     */
    protected $builder = [];

    /**
     * @param \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface[] $builder
     */
    public function __construct(array $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @throws \Spryker\Spryk\Exception\BuilderNotFoundException
     *
     * @return \Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function getBuilder(SprykDefinitionInterface $sprykDefinition): SprykBuilderInterface
    {
        $sprykBuilderName = $sprykDefinition->getBuilder();

        foreach ($this->builder as $builder) {
            if ($builder->getName() === $sprykBuilderName) {
                return $builder;
            }
        }

        throw new BuilderNotFoundException(sprintf(
            'Builder for Spryk "%s" not found. '
            . 'Maybe there is a typo in your spryk definition @spryk '
            . 'or the Spryk builder is not added to the SprykBuilderCollection',
            $sprykBuilderName
        ));
    }
}
