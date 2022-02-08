<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Validator;

class ConfigurationValidator implements ConfigurationValidatorInterface
{
    /**
     * @var array<\SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\Rules\ConfigurationValidatorRuleInterface>
     */
    protected $rules;

    /**
     * @var array<string>
     */
    protected $errorMessages = [];

    /**
     * @param array<\SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\Rules\ConfigurationValidatorRuleInterface> $rules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @param array $sprykConfig
     *
     * @return array
     */
    public function validate(array $sprykConfig): array
    {
        foreach ($this->rules as $rule) {
            if (!$rule->validate($sprykConfig)) {
                $this->errorMessages[] = $rule->getErrorMessage();
            }
        }

        return $this->errorMessages;
    }
}
