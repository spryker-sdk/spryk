<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Executor;


use Spryker\Spryk\Style\SprykStyleInterface;

interface SprykExecutorInterface
{
    /**
     * @param string $sprykName
     * @param SprykStyleInterface $style
     *
     * @return void
     */
    public function execute(string $sprykName, SprykStyleInterface $style): void;
}
