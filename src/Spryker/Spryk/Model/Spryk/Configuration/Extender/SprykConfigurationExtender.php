<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Configuration\Extender;

class SprykConfigurationExtender implements SprykConfigurationExtenderInterface
{
    /**
     * @var \Spryker\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface[]
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
