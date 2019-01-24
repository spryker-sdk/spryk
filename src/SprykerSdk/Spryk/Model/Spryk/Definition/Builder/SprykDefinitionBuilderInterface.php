<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
