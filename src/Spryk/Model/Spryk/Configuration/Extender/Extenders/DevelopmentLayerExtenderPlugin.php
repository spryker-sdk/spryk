<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders;

use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderPluginInterface;
use SprykerSdk\Spryk\SprykConfig;

class DevelopmentLayerExtenderPlugin extends AbstractExtender implements SprykConfigurationExtenderPluginInterface
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
            $sprykConfig[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS][SprykConfig::NAME_ARGUMENT_MODE][SprykConfig::NAME_ARGUMENT_KEY_DEFAULT] = $this->config->getDefaultDevelopmentMode();

            return $sprykConfig;
        }

        $sprykConfig[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS][SprykConfig::NAME_ARGUMENT_MODE][SprykConfig::NAME_ARGUMENT_KEY_VALUE] = $this->getDevelopmentLayer($sprykConfig);

        return $sprykConfig;
    }
}
