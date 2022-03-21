<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders;

use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderPluginInterface;
use SprykerSdk\Spryk\SprykConfig;

class DefaultValueExtenderPlugin extends AbstractExtender implements SprykConfigurationExtenderPluginInterface
{
    /**
     * @param array<mixed> $sprykConfig
     *
     * @return array<mixed>
     */
    public function extend(array $sprykConfig): array
    {
        $arguments = $this->getArguments($sprykConfig);

        foreach ($arguments as &$argument) {
            $values = $argument[SprykConfig::NAME_ARGUMENT_KEY_VALUES] ?? null;
            if (!empty($argument[SprykConfig::NAME_ARGUMENT_KEY_VALUE])) {
                continue;
            }
            if (!is_array($values)) {
                continue;
            }
            if (count($values) > 1) {
                continue;
            }

            $argument[SprykConfig::NAME_ARGUMENT_KEY_VALUE] = reset($values);
            $argument[SprykConfig::NAME_ARGUMENT_KEY_DEFAULT] = $argument[SprykConfig::NAME_ARGUMENT_KEY_VALUE];
        }

        return $this->setArguments($arguments, $sprykConfig);
    }
}
