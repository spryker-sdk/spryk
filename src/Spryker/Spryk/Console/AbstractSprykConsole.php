<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Console;

use Spryker\Spryk\SprykFacade;
use Spryker\Spryk\SprykFacadeInterface;
use Symfony\Component\Console\Command\Command;

abstract class AbstractSprykConsole extends Command
{
    /**
     * @var \Spryker\Spryk\SprykFacadeInterface|null
     */
    protected $facade;

    /**
     * @return \Spryker\Spryk\SprykFacadeInterface
     */
    protected function getFacade(): SprykFacadeInterface
    {
        if ($this->facade === null) {
            $this->facade = new SprykFacade();
        }

        return $this->facade;
    }

    /**
     * @param \Spryker\Spryk\SprykFacadeInterface $facade
     *
     * @return $this
     */
    public function setFacade(SprykFacadeInterface $facade): self
    {
        $this->facade = $facade;

        return $this;
    }
}
