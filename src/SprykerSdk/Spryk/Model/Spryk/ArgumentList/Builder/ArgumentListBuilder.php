<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\ArgumentList\Builder;

use SprykerSdk\Spryk\SprykConfig;
use Symfony\Component\Console\Input\InputOption;

class ArgumentListBuilder implements ArgumentListBuilderInterface
{
    /**
     * @param array $sprykDefinitions
     *
     * @return array
     */
    public function buildArgumentList(array $sprykDefinitions): array
    {
        $argumentList = [];
        $sprykArguments = $this->getArguments($sprykDefinitions);

        foreach ($sprykArguments as $argumentName => $argumentDefinition) {
            $inputOption = InputOption::VALUE_REQUIRED;
            if (isset($argumentDefinition['multiline']) || isset($argumentDefinition['isMultiple'])) {
                $inputOption = InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY;
            }

            $argumentList[$argumentName] = [
                'name' => $argumentName,
                'mode' => $inputOption,
                'description' => $argumentDefinition['description'],
            ];
        }

        return $argumentList;
    }

    /**
     * @param array $arguments
     *
     * @return array
     */
    protected function buildStandardArgumentList(array $arguments): array
    {
        $standardArguments = [];
        foreach ($arguments as $argumentName => $argumentDefinition) {
            $argumentDefinition['name'] = $argumentName;
            $argumentDefinition['description'] = sprintf('%s argument', $argumentName);

            $standardArguments[$argumentName] = $argumentDefinition;
        }

        return $standardArguments;
    }

    /**
     * @param string $sprykName
     * @param array $arguments
     *
     * @return array
     */
    protected function buildSprykArgumentList(string $sprykName, array $arguments): array
    {
        $sprykArguments = [];
        foreach ($arguments as $argumentName => $argumentDefinition) {
            $sprykArguments[$sprykName . '.' . $argumentName] = [
                'name' => $argumentName,
                'description' => sprintf('%s %s argument', $sprykName, $argumentName),
            ];
        }

        return $sprykArguments;
    }

    /**
     * @param array $sprykDefinitions
     *
     * @return array
     */
    protected function filterValueArguments(array $sprykDefinitions): array
    {
        return array_filter($sprykDefinitions, function ($argumentDefinition) {
            return (!isset($argumentDefinition[SprykConfig::NAME_ARGUMENT_KEY_VALUE]));
        });
    }

    /**
     * @param array $sprykDefinitions
     *
     * @return array
     */
    protected function getArguments(array $sprykDefinitions): array
    {
        $standardArguments = [];
        $sprykArguments = [];

        foreach ($this->filterValueArguments($sprykDefinitions) as $sprykName => $sprykDefinition) {
            $standardArguments += $this->buildStandardArgumentList($sprykDefinition[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS]);
            $sprykArguments += $this->buildSprykArgumentList($sprykName, $sprykDefinition[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS]);
        }

        return $standardArguments + $sprykArguments;
    }
}
