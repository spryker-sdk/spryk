<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
        if ($this->isAll($sprykConfig)) {
            $sprykConfig['arguments']['mode']['default'] = $this->config->getDefaultDevelopmentMode();

            return $sprykConfig;
        }

        $sprykConfig['arguments']['mode']['value'] = $this->getDevelopmentLayer($sprykConfig);

        return $sprykConfig;
    }
}
