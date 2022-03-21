<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Collection;

use SprykerSdk\Spryk\Exception\BuilderNotFoundException;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;

class SprykBuilderCollection implements SprykBuilderCollectionInterface
{
    /**
     * @var array<\SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface>
     */
    protected $builder = [];

    /**
     * @param array<\SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface> $builder
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
            $sprykBuilderName,
        ));
    }
}
