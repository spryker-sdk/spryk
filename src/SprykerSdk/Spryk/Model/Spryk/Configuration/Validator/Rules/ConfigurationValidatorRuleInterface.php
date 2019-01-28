<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
