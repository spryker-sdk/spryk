<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Executor;

use SprykerSdk\Spryk\Style\SprykStyleInterface;

interface SprykExecutorInterface
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
    public function execute(
        string $sprykName,
        array $includeOptionalSubSpryks,
        SprykStyleInterface $style,
        ?string $targetModuleName,
        ?string $dependentModuleName
    ): void;
}
