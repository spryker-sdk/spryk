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
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     * @param array $options
     *
     * @return void
     */
    public function execute(string $sprykName, SprykStyleInterface $style, array $options): void;
}
