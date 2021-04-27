<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
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
     * @param string|null $targetModuleName
     * @param string|null $dependentModuleName
     *
     * @return void
     */
    public function executeSpryk(
        string $sprykName,
        array $includeOptionalSubSpryks,
        SprykStyleInterface $style,
        ?string $targetModuleName = '',
        ?string $dependentModuleName = ''
    ): void;

    /**
     * @param int|null $level
     *
     * @return array
     */
    public function getSprykDefinitions(?int $level = null): array;

    /**
     * @param \SprykerSdk\Spryk\SprykFactory $factory
     *
     * @return $this
     */
    public function setFactory(SprykFactory $factory);

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
