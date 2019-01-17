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
     * @param string[] $includeOptionalSubSpryks
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function executeSpryk(string $sprykName, array $includeOptionalSubSpryks, SprykStyleInterface $style): void;

    /**
     * @return array
     */
    public function getSprykDefinitions(): array;

    /**
     * @param \Spryker\Spryk\SprykFactory $factory
     *
     * @return \Spryker\Spryk\SprykFacadeInterface
     */
    public function setFactory(SprykFactory $factory): self;

    /**
     * @param array $sprykDefinitions
     *
     * @return array
     */
    public function buildArgumentList(array $sprykDefinitions): array;

    /**
     * @param array $argumentsList
     *
     * @return int
     */
    public function generateArgumentList(array $argumentsList): int;

    /**
     * @return array
     */
    public function dumpArgumentList(): array;
}
