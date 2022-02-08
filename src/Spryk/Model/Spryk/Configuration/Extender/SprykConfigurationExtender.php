<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Extender;

class SprykConfigurationExtender implements SprykConfigurationExtenderInterface
{
    /**
     * @var array<\SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderPluginInterface>
     */
    protected $configExtenders;

    /**
     * @param array<\SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderPluginInterface> $configExtenders
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
