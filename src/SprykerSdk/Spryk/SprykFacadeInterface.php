<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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

    /**
     * @param string $sprykName
     * @param string|null $sprykMode
     *
     * @return array
     */
    public function getSprykDefinition(string $sprykName, ?string $sprykMode = null): array;
}
