<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders;

use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface;

class DevelopmentLayerExtender extends AbstractExtender implements SprykConfigurationExtenderInterface
{
    /**
     * @param array $sprykConfig
     *
     * @return array
     */
    public function extend(array $sprykConfig): array
    {
        if (!$this->isProject($sprykConfig)) {
            return $sprykConfig;
        }

        return $this->buildModeArgument($sprykConfig);
    }

    /**
     * @param array $sprykConfig
     *
     * @return array
     */
    protected function buildModeArgument(array $sprykConfig): array
    {
        if ($this->isBoth($sprykConfig)) {
            $sprykConfig['arguments']['mode']['default'] = 'core';

            return $sprykConfig;
        }

        $sprykConfig['arguments']['mode']['value'] = $this->getDevelopmentLayer($sprykConfig);

        return $sprykConfig;
    }
}
