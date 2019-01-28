<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Console;

use SprykerSdk\Spryk\SprykFacade;
use SprykerSdk\Spryk\SprykFacadeInterface;
use Symfony\Component\Console\Command\Command;

abstract class AbstractSprykConsole extends Command
{
    /**
     * @var \SprykerSdk\Spryk\SprykFacadeInterface|null
     */
    protected $facade;

    /**
     * @return \SprykerSdk\Spryk\SprykFacadeInterface
     */
    protected function getFacade(): SprykFacadeInterface
    {
        if ($this->facade === null) {
            $this->facade = new SprykFacade();
        }

        return $this->facade;
    }

    /**
     * @param \SprykerSdk\Spryk\SprykFacadeInterface $facade
     *
     * @return $this
     */
    public function setFacade(SprykFacadeInterface $facade)
    {
        $this->facade = $facade;

        return $this;
    }
}
