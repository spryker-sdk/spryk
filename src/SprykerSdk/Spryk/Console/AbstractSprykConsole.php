<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Console;

use SprykerSdk\Spryk\SprykFacade;
use SprykerSdk\Spryk\SprykFacadeInterface;
use SprykerSdk\Spryk\SprykFactory;
use Symfony\Component\Console\Command\Command;

abstract class AbstractSprykConsole extends Command
{
    /**
     * @var int
     */
    protected const CODE_SUCCESS = 0;

    /**
     * @var int
     */
    protected const CODE_ERROR = 1;

    /**
     * @var \SprykerSdk\Spryk\SprykFacadeInterface|null
     */
    protected $facade;

    /**
     * @var \SprykerSdk\Spryk\SprykFactory|null
     */
    protected $factory;

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

    /**
     * @return \SprykerSdk\Spryk\SprykFactory
     */
    protected function getFactory(): SprykFactory
    {
        if ($this->factory === null) {
            $this->factory = new SprykFactory();
        }

        return $this->factory;
    }

    /**
     * @param \SprykerSdk\Spryk\SprykFactory $factory
     *
     * @return $this
     */
    public function setFactory(SprykFactory $factory)
    {
        $this->factory = $factory;

        return $this;
    }
}
