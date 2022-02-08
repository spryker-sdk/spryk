<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Wrapper;

use SprykerSdk\Spryk\Model\Spryk\Builder\AbstractBuilder;

class WrapperSpryk extends AbstractBuilder
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'wrapper';
    }

    /**
     * @return void
     */
    protected function build(): void
    {
        // Noop, only preSpryks and postSpryks will be build
    }
}
