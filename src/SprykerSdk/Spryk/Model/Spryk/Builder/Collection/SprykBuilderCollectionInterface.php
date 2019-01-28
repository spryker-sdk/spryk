<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Collection;

use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;

interface SprykBuilderCollectionInterface
{
    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    public function getBuilder(SprykDefinitionInterface $sprykDefinition): SprykBuilderInterface;
}
