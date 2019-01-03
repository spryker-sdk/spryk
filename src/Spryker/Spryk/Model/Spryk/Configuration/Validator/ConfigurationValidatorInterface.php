<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Configuration\Validator;

interface ConfigurationValidatorInterface
{
    /**
     * @param array $sprykConfig
     *
     * @return array
     */
    public function validate(array $sprykConfig): array;
}
