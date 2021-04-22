<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\Rules;

class LevelRule implements ConfigurationValidatorRuleInterface
{
    protected const LEVEL_CONFIG_NAME = 'level';
    /**
     * @var string
     */
    protected $errorMessage = 'Level is required value of configuration';

    /**
     * @var array
     */
    protected $availableLevels;

    public function __construct(array $availableLevels)
    {
        $this->availableLevels = $availableLevels;
    }

    /**
     * @param array $sprykConfig
     *
     * @return bool
     */
    public function validate(array $sprykConfig): bool
    {
        if (!isset($sprykConfig[static::LEVEL_CONFIG_NAME])) {
            return false;
        }

        $this->buildInvalidValueErrorMessage($sprykConfig[static::LEVEL_CONFIG_NAME]);

        if (in_array($sprykConfig[static::LEVEL_CONFIG_NAME], $this->availableLevels, true)) {
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
            implode(', ', $this->availableLevels)
        );
    }
}
