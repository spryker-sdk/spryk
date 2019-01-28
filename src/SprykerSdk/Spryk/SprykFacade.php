<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk;

use SprykerSdk\Spryk\Style\SprykStyleInterface;

class SprykFacade implements SprykFacadeInterface
{
    /**
     * @var \SprykerSdk\Spryk\SprykFactory|null
     */
    protected $factory;

    /**
     * @param string $sprykName
     * @param string[] $includeOptionalSubSpryks
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function executeSpryk(string $sprykName, array $includeOptionalSubSpryks, SprykStyleInterface $style): void
    {
        $this->getFactory()->createSprykExecutor()->execute($sprykName, $includeOptionalSubSpryks, $style);
    }

    /**
     * @return array
     */
    public function getSprykDefinitions(): array
    {
        return $this->getFactory()->createSprykDefinitionDumper()->dump();
    }

    /**
     * @codeCoverageIgnore
     *
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
     * @return \SprykerSdk\Spryk\SprykFacadeInterface
     */
    public function setFactory(SprykFactory $factory): SprykFacadeInterface
    {
        $this->factory = $factory;

        return $this;
    }

    /**
     * @param array $argumentsList
     *
     * @return int
     */
    public function generateArgumentList(array $argumentsList): int
    {
        return $this->getFactory()->createArgumentListGenerator()->generateArgumentList($argumentsList);
    }

    /**
     * @return array
     */
    public function getArgumentList(): array
    {
        return $this->getFactory()->createArgumentListReader()->getArgumentList();
    }
}
