<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     * @param array $options
     *
     * @return void
     */
    public function executeSpryk(string $sprykName, SprykStyleInterface $style, array $options): void
    {
        $this->getFactory()->createSprykExecutor()->execute($sprykName, $style, $options);
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

    /**
     * @param string $sprykName
     * @param string|null $sprykMode
     *
     * @return array
     */
    public function getSprykDefinition(string $sprykName, ?string $sprykMode = null): array
    {
        $sprykMode = $sprykMode ?: $this->getFactory()->getConfig()->getDefaultDevelopmentMode();

        return $this->getFactory()
            ->createConfigurationFactory()
            ->createConfigurationLoader()
            ->loadSpryk($sprykName, $sprykMode);
    }
}
