<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders;

use SprykerSdk\Spryk\SprykConfig;

abstract class AbstractExtender
{
    protected const ARGUMENTS = 'arguments';

    protected const NAME_ARGUMENT_LAYER = 'layer';
    protected const NAME_ARGUMENT_MODE = 'mode';

    protected const NAME_ARGUMENT_DEFAULT = 'default';

    protected const NAME_PLACEHOLDER_MODULE = '{{ module }}';
    protected const NAME_PLACEHOLDER_LAYER = '{{ layer }}';
    protected const NAME_PLACEHOLDER_ORGANISATION = '{{ organization }}';

    protected const NAME_APPLICATION_LAYER_ZED = 'Zed';

    protected const NAME_DEVELOPMENT_LAYER_CORE = 'core';
    protected const NAME_DEVELOPMENT_LAYER_PROJECT = 'project';
    protected const NAME_DEVELOPMENT_LAYER_BOTH = 'both';

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
     * @return string|null
     */
    protected function getDevelopmentLayer(array $sprykConfig): ?string
    {
        return $sprykConfig[static::NAME_ARGUMENT_MODE] ?? null;
    }

    /**
     * @param array $sprykConfig
     *
     * @return bool
     */
    protected function isProject(array $sprykConfig): bool
    {
        return $this->getDevelopmentLayer($sprykConfig) === static::NAME_DEVELOPMENT_LAYER_PROJECT;
    }

    /**
     * @param array $sprykConfig
     *
     * @return bool
     */
    protected function isCore(array $sprykConfig): bool
    {
        return $this->getDevelopmentLayer($sprykConfig) === static::NAME_DEVELOPMENT_LAYER_CORE;
    }

    /**
     * @param array $sprykConfig
     *
     * @return bool
     */
    protected function isBoth(array $sprykConfig): bool
    {
        return $this->getDevelopmentLayer($sprykConfig) === static::NAME_DEVELOPMENT_LAYER_BOTH;
    }
}
