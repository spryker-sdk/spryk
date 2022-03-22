<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\Rules;

use SprykerSdk\Spryk\SprykConfig;

class LevelRule implements ConfigurationValidatorRuleInterface
{
    /**
     * @var string
     */
    protected $errorMessage = 'Level is required value of configuration';

    /**
     * @var \SprykerSdk\Spryk\SprykConfig
     */
    protected SprykConfig $config;

    /**
     * @param \SprykerSdk\Spryk\SprykConfig $config
     */
    public function __construct(SprykConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param array $sprykConfig
     *
     * @return bool
     */
    public function validate(array $sprykConfig): bool
    {
        if (!isset($sprykConfig[SprykConfig::SPRYK_DEFINITION_KEY_LEVEL])) {
            return false;
        }

        $this->buildInvalidValueErrorMessage($sprykConfig[SprykConfig::SPRYK_DEFINITION_KEY_LEVEL]);

        if (in_array($sprykConfig[SprykConfig::SPRYK_DEFINITION_KEY_LEVEL], $this->config->getAvailableLevels(), true)) {
            return true;
        }

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
    protected function buildInvalidValueErrorMessage(string $value): void
    {
        $this->errorMessage = sprintf(
            'Spryk level of %s is invalid. Please set `level` one of: %s.',
            $value,
            implode(', ', $this->config->getAvailableLevels()),
        );
    }
}
