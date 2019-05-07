<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders;

use SprykerSdk\Spryk\SprykConfig;

abstract class AbstractExtender
{
    protected const ARGUMENTS = 'arguments';

    protected const NAME_ARGUMENT_APPLICATION = 'application';
    protected const NAME_ARGUMENT_MODE = 'mode';

    protected const NAME_ARGUMENT_DEFAULT = 'default';

    protected const NAME_PLACEHOLDER_ORGANISATION = '{{ organization }}';
    protected const NAME_PLACEHOLDER_APPLICATION = '{{ application }}';
    protected const NAME_PLACEHOLDER_MODULE = '{{ module }}';

    protected const NAME_APPLICATION_LAYER_ZED = 'Zed';

    protected const NAME_DEVELOPMENT_LAYER_CORE = 'core';
    protected const NAME_DEVELOPMENT_LAYER_PROJECT = 'project';
    protected const NAME_DEVELOPMENT_LAYER_ALL = 'all';

    /**
     * @var \SprykerSdk\Spryk\SprykConfig
     */
    protected $config;

    /**
     * @param \SprykerSdk\Spryk\SprykConfig $config
     */
    public function __construct(SprykConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param array $sprykConfig
     *
     * @return array
     */
    protected function getArguments(array $sprykConfig): array
    {
        return $sprykConfig[static::ARGUMENTS] ?? [];
    }

    /**
     * @param array $arguments
     * @param array $sprykConfig
     *
     * @return array
     */
    protected function setArguments(array $arguments, array $sprykConfig): array
    {
        $sprykConfig[static::ARGUMENTS] = $arguments;

        return $sprykConfig;
    }

    /**
     * @param array $sprykConfig
     *
     * @return array
     */
    protected function getDevelopmentLayer(array $sprykConfig): array
    {
        return isset($sprykConfig[static::NAME_ARGUMENT_MODE]) ? explode('|', $sprykConfig[static::NAME_ARGUMENT_MODE]) : [];
    }

    /**
     * @param array $sprykConfig
     *
     * @return bool
     */
    protected function isProject(array $sprykConfig): bool
    {
        return in_array(static::NAME_DEVELOPMENT_LAYER_PROJECT, $this->getDevelopmentLayer($sprykConfig));
    }

    /**
     * @param array $sprykConfig
     *
     * @return bool
     */
    protected function isAll(array $sprykConfig): bool
    {
        return $this->getDevelopmentLayer($sprykConfig) === static::NAME_DEVELOPMENT_LAYER_ALL;
    }
}
