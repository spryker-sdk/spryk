<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\Rules;

class DevelopmentLayerRule implements ConfigurationValidatorRuleInterface
{
    protected const NAME_CONFIG_MODE = 'mode';

    /**
     * @var string[]
     */
    protected $availableDevelopmentLayers;

    /**
     * @var string
     */
    protected $errorMessage;

    /**
     * @param array $availableDevelopmentLayers
     */
    public function __construct(array $availableDevelopmentLayers)
    {
        $this->availableDevelopmentLayers = $availableDevelopmentLayers;
    }

    /**
     * @param array $sprykConfig
     *
     * @return bool
     */
    public function validate(array $sprykConfig): bool
    {
        if (!isset($sprykConfig[static::NAME_CONFIG_MODE])) {
            return true;
        }

        if (in_array($sprykConfig[static::NAME_CONFIG_MODE], $this->availableDevelopmentLayers, true)) {
            return true;
        }

        $this->buildErrorMessage($sprykConfig[static::NAME_CONFIG_MODE]);

        return false;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * @param string $value
     *
     * @return void
     */
    protected function buildErrorMessage(string $value): void
    {
        $template = 'Development layer `%s` is unavailable. Please set `mode` one of: %s.';
        $availableDevelopmentLayers = implode(', ', $this->availableDevelopmentLayers);

        $this->errorMessage = sprintf($template, $value, $availableDevelopmentLayers);
    }
}
