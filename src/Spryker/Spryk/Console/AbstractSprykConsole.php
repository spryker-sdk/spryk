<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Console;

use Spryker\Spryk\SprykFacade;
use Symfony\Component\Console\Command\Command;

abstract class AbstractSprykConsole extends Command
{
    /**
     * @var \Spryker\Spryk\SprykFacade|null
     */
    protected $facade;

    /**
     * @return \Spryker\Spryk\SprykFacade
     */
    protected function getFacade(): SprykFacade
    {
        if ($this->facade === null) {
            $this->facade = new SprykFacade();
        }

        return $this->facade;
    }

    /**
     * @param \Spryker\Spryk\SprykFacade $facade
     *
     * @return $this
     */
    public function setFacade(SprykFacade $facade): self
    {
        $this->facade = $facade;

        return $this;
    }
}
