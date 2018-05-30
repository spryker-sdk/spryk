<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk;

use Spryker\Spryk\Style\SprykStyleInterface;

interface SprykFacadeInterface
{
    /**
     * @param string $sprykName
     * @param array|null $includeOptionalSubSpryks
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function executeSpryk(string $sprykName, ?array $includeOptionalSubSpryks, SprykStyleInterface $style): void;

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface[]
     */
    public function getSprykDefinitions(): array;

    /**
     * @param \Spryker\Spryk\SprykFactory $factory
     *
     * @return \Spryker\Spryk\SprykFacadeInterface
     */
    public function setFactory(SprykFactory $factory): self;
}
