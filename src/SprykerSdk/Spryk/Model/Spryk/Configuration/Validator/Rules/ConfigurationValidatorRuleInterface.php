<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\Rules;

interface ConfigurationValidatorRuleInterface
{
    /**
     * @param array $sprykConfig
     *
     * @return bool
     */
    public function validate(array $sprykConfig): bool;

    /**
     * @return string
     */
    public function getErrorMessage(): string;
}
