<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders;

use SprykerSdk\Spryk\SprykConfig;

abstract class AbstractExtender
{
    /**
     * @var string
     */
    protected const NAME_PLACEHOLDER_MODULE = '{{ module }}';

    /**
     * @var string
     */
    protected const NAME_PLACEHOLDER_LAYER = '{{ layer }}';

    /**
     * @var string
     */
    protected const NAME_APPLICATION_LAYER_ZED = 'Zed';

    /**
     * @var \SprykerSdk\Spryk\SprykConfig
     */
    protected SprykConfig $config;

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
        return $sprykConfig[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS] ?? [];
    }

    /**
     * @param array $arguments
     * @param array $sprykConfig
     *
     * @return array
     */
    protected function setArguments(array $arguments, array $sprykConfig): array
    {
        $sprykConfig[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS] = $arguments;

        return $sprykConfig;
    }

    /**
     * @param array $sprykConfig
     *
     * @return string|null
     */
    protected function getDevelopmentLayer(array $sprykConfig): ?string
    {
        return $sprykConfig[SprykConfig::NAME_ARGUMENT_MODE] ?? null;
    }

    /**
     * @param array $sprykConfig
     *
     * @return bool
     */
    protected function isProject(array $sprykConfig): bool
    {
        return $this->getDevelopmentLayer($sprykConfig) === SprykConfig::NAME_DEVELOPMENT_LAYER_PROJECT;
    }

    /**
     * @param array $sprykConfig
     *
     * @return bool
     */
    protected function isCore(array $sprykConfig): bool
    {
        return $this->getDevelopmentLayer($sprykConfig) === SprykConfig::NAME_DEVELOPMENT_LAYER_CORE;
    }

    /**
     * @param array $sprykConfig
     *
     * @return bool
     */
    protected function isBoth(array $sprykConfig): bool
    {
        return $this->getDevelopmentLayer($sprykConfig) === SprykConfig::NAME_DEVELOPMENT_LAYER_BOTH;
    }
}
