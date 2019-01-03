<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Configuration\Validator\Rules;

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
