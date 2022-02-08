<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Merger;

use SprykerSdk\Spryk\SprykConfig;

class SprykConfigurationMerger implements SprykConfigurationMergerInterface
{
    /**
     * @var string
     */
    protected $rootSprykName = 'spryk';

    /**
     * @param array $sprykDefinition
     * @param array $rootConfiguration
     *
     * @return array
     */
    public function merge(array $sprykDefinition, array $rootConfiguration): array
    {
        $sprykDefinition = $this->doMerge($rootConfiguration, $sprykDefinition);
        $sprykDefinition = $this->doMergeSubSpryks($rootConfiguration, $sprykDefinition);

        return $sprykDefinition;
    }

    /**
     * @param array $rootConfiguration
     * @param array $sprykDefinition
     *
     * @return array
     */
    protected function doMerge(array $rootConfiguration, array $sprykDefinition): array
    {
        $rootConfiguration = $this->buildRootConfigByMode($rootConfiguration, $sprykDefinition[SprykConfig::NAME_ARGUMENT_MODE]);
        $sprykDefinition[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS] = $this->mergeArguments(
            $sprykDefinition[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS],
            $rootConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS],
        );

        $sprykDefinition[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS] = $this->addRootArguments(
            $sprykDefinition[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS],
            $rootConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS],
        );

        return $sprykDefinition;
    }

    /**
     * @param array $rootConfiguration
     * @param array $sprykDefinition
     *
     * @return array
     */
    protected function doMergeSubSpryks(array $rootConfiguration, array $sprykDefinition): array
    {
        if (isset($sprykDefinition['postSpryks'])) {
            $sprykDefinition['postSpryks'] = $this->mergeSubSprykArguments($sprykDefinition['postSpryks'], $rootConfiguration);
        }

        if (isset($sprykDefinition['preSpryks'])) {
            $sprykDefinition['preSpryks'] = $this->mergeSubSprykArguments($sprykDefinition['preSpryks'], $rootConfiguration);
        }

        return $sprykDefinition;
    }

    /**
     * @param array $subSpryks
     * @param array $rootConfiguration
     *
     * @return array
     */
    protected function mergeSubSprykArguments(array $subSpryks, array $rootConfiguration): array
    {
        $mergedSubSpryks = [];
        foreach ($subSpryks as $subSpryk) {
            if (!is_array($subSpryk)) {
                $mergedSubSpryks[] = $subSpryk;

                continue;
            }

            $mergedSubSpryks[] = $this->mergeSubSpryk($subSpryk, $rootConfiguration);
        }

        return $mergedSubSpryks;
    }

    /**
     * @param array $subSpryk
     * @param array $rootConfiguration
     *
     * @return array
     */
    protected function mergeSubSpryk(array $subSpryk, array $rootConfiguration): array
    {
        $sprykName = array_keys($subSpryk)[0];
        $subSprykDefinition = $subSpryk[$sprykName];

        if (isset($subSprykDefinition[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS])) {
            $mergedArguments = $this->mergeArguments($subSprykDefinition[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS], $rootConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS]);
            $subSpryk[$sprykName][SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS] = $mergedArguments;
        }

        return $subSpryk;
    }

    /**
     * @param array $arguments
     * @param array $rootArguments
     *
     * @return array
     */
    protected function mergeArguments(array $arguments, array $rootArguments): array
    {
        $mergedArguments = [];
        foreach ($arguments as $argumentName => $argumentDefinition) {
            if (!isset($rootArguments[$argumentName])) {
                $mergedArguments[$argumentName] = $argumentDefinition;

                continue;
            }

            $mergedArgumentDefinition = $this->getMergedArgumentDefinition($rootArguments, $argumentName, $argumentDefinition);
            $mergedArguments[$argumentName] = $mergedArgumentDefinition;
        }

        return $mergedArguments;
    }

    /**
     * @param array $rootArguments
     * @param string $argumentName
     * @param array $argumentDefinition
     *
     * @return array
     */
    protected function getMergedArgumentDefinition(array $rootArguments, string $argumentName, array $argumentDefinition): array
    {
        if (!isset($rootArguments[$argumentName]['type'])) {
            return $argumentDefinition;
        }
        $mergeType = $rootArguments[$argumentName]['type'];
        $mergeValue = $rootArguments[$argumentName][SprykConfig::NAME_ARGUMENT_KEY_VALUE];

        $mergedArgumentDefinition = [];

        foreach ($argumentDefinition as $definitionKey => $definitionValue) {
            if ($mergeType === 'prepend') {
                $mergedArgumentDefinition[$definitionKey] = $mergeValue . $definitionValue;
            }
        }

        return $mergedArgumentDefinition;
    }

    /**
     * @param array $arguments
     * @param array $rootArguments
     *
     * @return array
     */
    protected function addRootArguments(array $arguments, array $rootArguments): array
    {
        $mergedArguments = $arguments;
        foreach ($rootArguments as $argumentName => $argumentDefinition) {
            if (isset($arguments[$argumentName])) {
                continue;
            }
            if (isset($argumentDefinition['type'])) {
                continue;
            }
            $mergedArguments[$argumentName] = $argumentDefinition;
        }

        return $mergedArguments;
    }

    /**
     * @param array $rootConfiguration
     * @param string $sprykMode
     *
     * @return array
     */
    protected function buildRootConfigByMode(array $rootConfiguration, string $sprykMode): array
    {
        $rootArguments = $rootConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS];

        $mode = $sprykMode;

        if (!isset($rootConfiguration[$mode])) {
            return $rootConfiguration;
        }

        $rootConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS] = array_merge($rootArguments, $rootConfiguration[$mode][SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS]);

        return $rootConfiguration;
    }
}
