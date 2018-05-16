<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk;

use Spryker\Spryk\Style\SprykStyleInterface;

class SprykFacade
{
    /**
     * @var \Spryker\Spryk\SprykFactory|null
     */
    protected $factory;

    /**
     * @param string $sprykName
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function executeSpryk(string $sprykName, SprykStyleInterface $style): void
    {
        $this->getFactory()->createSprykExecutor()->execute($sprykName, $style);
    }

    /**
     * @return array
     */
    public function getSprykDefinitions()
    {
        return $this->getFactory()->createSprykDefinitionDumper()->dump();
    }

    /**
     * @return \Spryker\Spryk\SprykFactory
     */
    protected function getFactory(): SprykFactory
    {
        if ($this->factory === null) {
            $this->factory = new SprykFactory();
        }

        return $this->factory;
    }

    /**
     * @param \Spryker\Spryk\SprykFactory $factory
     *
     * @return \Spryker\Spryk\SprykFacade
     */
    public function setFactory(SprykFactory $factory): SprykFacade
    {
        $this->factory = $factory;

        return $this;
    }
}
