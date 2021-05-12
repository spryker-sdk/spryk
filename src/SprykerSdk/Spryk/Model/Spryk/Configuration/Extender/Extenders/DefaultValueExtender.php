<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders;

use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface;

class DefaultValueExtender extends AbstractExtender implements SprykConfigurationExtenderInterface
{
    /**
     * @param mixed[] $sprykConfig
     *
     * @return mixed[]
     */
    public function extend(array $sprykConfig): array
    {
        $arguments = $this->getArguments($sprykConfig);

        foreach ($arguments as &$argument) {
            $values = $argument[static::NAME_ARGUMENT_KEY_VALUES] ?? null;
            if (!empty($argument[static::NAME_ARGUMENT_KEY_VALUE]) || !is_array($values) || count($values) > 1) {
                continue;
            }

            $argument[static::NAME_ARGUMENT_KEY_VALUE] = reset($values);
            $argument[static::NAME_ARGUMENT_KEY_DEFAULT] = $argument[static::NAME_ARGUMENT_KEY_VALUE];
        }

        return $this->setArguments($arguments, $sprykConfig);
    }
}
