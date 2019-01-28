<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Validator;

class ConfigurationValidator implements ConfigurationValidatorInterface
{
    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\Rules\ConfigurationValidatorRuleInterface[]
     */
    protected $rules;

    /**
     * @var string[]
     */
    protected $errorMessages = [];

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\Rules\ConfigurationValidatorRuleInterface[] $rules
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
