<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk;

use SprykerSdk\Kernel;
use SprykerSdk\Spryk\Model\Spryk\Executor\Configuration\SprykExecutorConfigurationInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class SprykFacade implements SprykFacadeInterface
{
    /**
     * @var \SprykerSdk\Spryk\SprykFactory|null
     */
    protected ?SprykFactory $factory = null;

    /**
     * This is only needed when the SprykFacadeInterface is used from an external module like `spryker-sdk/spryk-gui`.
     * When using the console commands provided by this the factory will be auto-wired by the application.
     *
     * @param \SprykerSdk\Spryk\SprykFactory|null $factory
     */
    public function __construct(?SprykFactory $factory = null)
    {
        if ($factory) {
            $this->factory = $factory;

            return;
        }

        $this->factory = $this->getSprykFactory();
    }

    /**
     * This method is only required to be able to use `new SprykFacade()` in other packages e.g. `spryker-sdk/spryk-gui`.
     *
     * @return SprykFactory
     */
    protected function getSprykFactory(): SprykFactory
    {
        if ($this->factory) {
            return $this->factory;
        }

        $kernel = (new Kernel('prod', false));
        $kernel->boot();

        $container = $kernel->getContainer();

        /** @var SprykFactory $factory */
        $factory = $container->get(SprykFactory::class);

        return $factory;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Executor\Configuration\SprykExecutorConfigurationInterface $sprykExecutorConfiguration
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function executeSpryk(
        SprykExecutorConfigurationInterface $sprykExecutorConfiguration,
        SprykStyleInterface $style
    ): void {
        $this->factory->getExecutor()->execute($sprykExecutorConfiguration, $style);
    }

    /**
     * @param int|null $level
     *
     * @return array
     */
    public function getSprykDefinitions(?int $level = null): array
    {
        return $this->factory->getDefinitionDumper()->dump($level);
    }

    /**
     * @param array $argumentsList
     *
     * @return int
     */
    public function generateArgumentList(array $argumentsList): int
    {
        return $this->factory->getArgumentListGenerator()->generateArgumentList($argumentsList);
    }

    /**
     * @return array
     */
    public function getArgumentList(): array
    {
        return $this->factory->getArgumentListReader()->getArgumentList();
    }

    /**
     * @param string $sprykName
     * @param string|null $sprykMode
     *
     * @return array
     */
    public function getSprykDefinition(string $sprykName, ?string $sprykMode = null): array
    {
        return $this->factory->getConfigurationLoader()->loadSpryk($sprykName, $sprykMode);
    }
}
