<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Collection;

use SprykerSdk\Spryk\Exception\BuilderNotFoundException;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;

class SprykBuilderCollection implements SprykBuilderCollectionInterface
{
    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface[]
     */
    protected $builder = [];

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface[] $builder
     */
    public function __construct(array $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @throws \SprykerSdk\Spryk\Exception\BuilderNotFoundException
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
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
