<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk;

use SprykerSdk\Spryk\Style\SprykStyleInterface;

interface SprykFacadeInterface
{
    /**
     * @param string $sprykName
     * @param string[] $includeOptionalSubSpryks
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function executeSpryk(string $sprykName, array $includeOptionalSubSpryks, SprykStyleInterface $style): void;

    /**
     * @return array
     */
    public function getSprykDefinitions(): array;

    /**
     * @param \SprykerSdk\Spryk\SprykFactory $factory
     *
     * @return \SprykerSdk\Spryk\SprykFacadeInterface
     */
    public function setFactory(SprykFactory $factory): self;

    /**
     * @param array $argumentsList
     *
     * @return int
     */
    public function generateArgumentList(array $argumentsList): int;

    /**
     * @return array
     */
    public function getArgumentList(): array;
}
