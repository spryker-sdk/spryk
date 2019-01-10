<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Configuration\Validator;

class ConfigurationValidator implements ConfigurationValidatorInterface
{
    /**
     * @var \Spryker\Spryk\Model\Spryk\Configuration\Validator\Rules\ConfigurationValidatorRuleInterface[]
     */
    protected $rules;

    /**
     * @var string[]
     */
    protected $errorMessages = [];

    /**
     * @param \Spryker\Spryk\Model\Spryk\Configuration\Validator\Rules\ConfigurationValidatorRuleInterface[] $rules
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
