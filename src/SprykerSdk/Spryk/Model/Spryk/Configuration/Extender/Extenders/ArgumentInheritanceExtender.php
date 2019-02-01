<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders;

use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface;

class ArgumentInheritanceExtender extends AbstractExtender implements SprykConfigurationExtenderInterface
{
    protected const KEY_SPRYK_NOT_INHERITABLE_NAMES = 'sprykNames';
    protected const KEY_SPRYK_NOT_INHERITABLE_TYPES = 'sprykTypes';
    protected const KEY_SPRYK_NOT_INHERITABLE_DEFAULT = 'default';
    protected const TOKEN_SPRYK_NOT_INHERITABLE_ARGUMENT_ALL = '*';

    protected const KEY_ARGUMENT_INHERIT = 'inherit';
    protected const KEY_ARGUMENT_SPRYK_NAME = 'sprykName';
    protected const KEY_ARGUMENT_SPRYK_TYPE = 'spryk';

    /**
     * @param array $sprykConfig
     *
     * @return array
     */
    public function extend(array $sprykConfig): array
    {
        $arguments = $this->getArguments($sprykConfig);

        $notInheritableArgumentList = $this->config->getNotInheritableArgumentList();
        $notInheritableArgumentList = $this->getExcludedArgumentList($sprykConfig, $notInheritableArgumentList);

        foreach ($arguments as $argumentName => $value) {
            $inherit = $this->getInheritValue($argumentName, $notInheritableArgumentList);

            $arguments[$argumentName][static::KEY_ARGUMENT_INHERIT] = $inherit;
        }

        return $this->setArguments($arguments, $sprykConfig);
    }

    /**
     * @param array $sprykConfig
     * @param array $notInheritableArgumentList
     *
     * @return array|null
     */
    protected function getExcludedArgumentListBySprykName(array $sprykConfig, array $notInheritableArgumentList): ?array
    {
        if (!isset($sprykConfig[static::KEY_ARGUMENT_SPRYK_NAME])) {
            return null;
        }

        $sprykName = $sprykConfig[static::KEY_ARGUMENT_SPRYK_NAME];

        if (!isset($notInheritableArgumentList[static::KEY_SPRYK_NOT_INHERITABLE_NAMES])) {
            return null;
        }

        foreach ($notInheritableArgumentList[static::KEY_SPRYK_NOT_INHERITABLE_NAMES] as $notInheritableSprykName => $argumentList) {
            if ($notInheritableSprykName === $sprykName) {
                return $argumentList;
            }

            if ($notInheritableSprykName[0] !== '/' || $notInheritableSprykName[-1] !== '/') {
                return null;
            }

            if ((bool)preg_match($notInheritableSprykName, $sprykName)) {
                return $argumentList;
            }
        }

        return null;
    }

    /**
     * @param array $sprykConfig
     * @param array $notInheritableArgumentList
     *
     * @return array|null
     */
    protected function getExcludedArgumentListBySprykType(array $sprykConfig, array $notInheritableArgumentList): ?array
    {
        if (!isset($sprykConfig[static::KEY_ARGUMENT_SPRYK_TYPE])) {
            return null;
        }

        if (!isset($notInheritableArgumentList[static::KEY_SPRYK_NOT_INHERITABLE_TYPES])) {
            return null;
        }

        $sprykType = $sprykConfig[static::KEY_ARGUMENT_SPRYK_TYPE];

        if (!array_key_exists($sprykType, $notInheritableArgumentList[static::KEY_SPRYK_NOT_INHERITABLE_TYPES])) {
            return null;
        }

        return $notInheritableArgumentList[static::KEY_SPRYK_NOT_INHERITABLE_TYPES][$sprykType];
    }

    /**
     * @param array $notInheritableArgumentList
     *
     * @return array
     */
    protected function getExcludedDefaultArgumentList(array $notInheritableArgumentList): array
    {

        return $notInheritableArgumentList[static::KEY_SPRYK_NOT_INHERITABLE_DEFAULT] ?? [];
    }

    /**
     * @param array $sprykConfig
     * @param array $notInheritableArgumentList
     *
     * @return array
     */
    protected function getExcludedArgumentList(array $sprykConfig, array $notInheritableArgumentList): array
    {
        $notInheritableArgumentListBySprykName = $this->getExcludedArgumentListBySprykName($sprykConfig, $notInheritableArgumentList);

        if ($notInheritableArgumentListBySprykName !== null) {
            return $notInheritableArgumentListBySprykName;
        }

        $notInheritableArgumentListBySprykType = $this->getExcludedArgumentListBySprykType($sprykConfig, $notInheritableArgumentList);

        if ($notInheritableArgumentListBySprykType !== null) {
            return $notInheritableArgumentListBySprykType;
        }

        return $this->getExcludedDefaultArgumentList($notInheritableArgumentList);
    }

    /**
     * @param array $notInheritableArgumentList
     *
     * @return bool
     */
    protected function areAllArgumentsExcluded(array $notInheritableArgumentList): bool
    {
        return in_array(
            static::TOKEN_SPRYK_NOT_INHERITABLE_ARGUMENT_ALL,
            $notInheritableArgumentList,
            true
        );
    }

    /**
     * @param string $argumentName
     * @param array $notInheritableArgumentList
     *
     * @return bool
     */
    protected function getInheritValue(string $argumentName, array $notInheritableArgumentList): bool
    {
        return $this->areAllArgumentsExcluded($notInheritableArgumentList)
            ? false
            : !in_array($argumentName, $notInheritableArgumentList, true);
    }
}
