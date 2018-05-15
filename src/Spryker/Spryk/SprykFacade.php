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
     * @return \Spryker\Spryk\SprykFactory
     */
    protected function getFactory(): SprykFactory
    {
        return new SprykFactory();
    }

    /**
     * @return array
     */
    public function getSprykDefinitions()
    {
        return $this->getFactory()->createSprykDefinitionDumper()->dump();
    }
}
