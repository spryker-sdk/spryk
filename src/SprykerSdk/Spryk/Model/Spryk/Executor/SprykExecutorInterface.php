<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
