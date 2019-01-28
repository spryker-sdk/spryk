<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Extender;

class SprykConfigurationExtender implements SprykConfigurationExtenderInterface
{
    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface[]
     */
    protected $configExtenders;

    /**
     * @param array $configExtenders
     */
    public function __construct(array $configExtenders)
    {
        $this->configExtenders = $configExtenders;
    }

    /**
     * @param array $sprykConfig
     *
     * @return array
     */
    public function extend(array $sprykConfig): array
    {
        foreach ($this->configExtenders as $configExtender) {
            $sprykConfig = $configExtender->extend($sprykConfig);
        }

        return $sprykConfig;
    }
}
