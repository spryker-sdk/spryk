<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Builder;

use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

interface SprykDefinitionBuilderInterface
{
    /**
     * @param string $sprykName
     * @param array|null $preDefinedDefinition
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function buildDefinition(string $sprykName, ?array $preDefinedDefinition = null): SprykDefinitionInterface;

    /**
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilderInterface
     */
    public function setStyle(SprykStyleInterface $style): self;
}
