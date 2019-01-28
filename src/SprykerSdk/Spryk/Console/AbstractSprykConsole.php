<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
