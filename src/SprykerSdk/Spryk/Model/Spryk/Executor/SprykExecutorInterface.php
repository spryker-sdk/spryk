<?php

/**
 * MIT License
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
     *
     * @return void
     */
    public function execute(string $sprykName, array $includeOptionalSubSpryks, SprykStyleInterface $style): void;
}
