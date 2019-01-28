<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Validator;

interface ConfigurationValidatorInterface
{
    /**
     * @param array $sprykConfig
     *
     * @return array
     */
    public function validate(array $sprykConfig): array;
}
