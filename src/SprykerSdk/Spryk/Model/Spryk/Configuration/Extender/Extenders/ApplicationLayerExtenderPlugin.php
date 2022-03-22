<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders;

use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderPluginInterface;
use SprykerSdk\Spryk\SprykConfig;

class ApplicationLayerExtenderPlugin extends AbstractExtender implements SprykConfigurationExtenderPluginInterface
{
    /**
     * @param array $sprykConfig
     *
     * @return array
     */
    public function extend(array $sprykConfig): array
    {
        if (!$this->isProject($sprykConfig)) {
            return $sprykConfig;
        }

        return $this->buildApplicationLayerArgument($sprykConfig);
    }

    /**
     * @param array $sprykConfig
     *
     * @return array
     */
    protected function buildApplicationLayerArgument(array $sprykConfig): array
    {
        $arguments = $this->getArguments($sprykConfig);

        if (isset($arguments[SprykConfig::NAME_ARGUMENT_LAYER][SprykConfig::NAME_ARGUMENT_KEY_DEFAULT])) {
            return $sprykConfig;
        }

        $applicationLayer = $this->getApplicationLayer($arguments);

        if ($applicationLayer === null) {
            return $sprykConfig;
        }

        if ($this->isLayerPlaceholderExist($arguments)) {
            $arguments[SprykConfig::NAME_ARGUMENT_LAYER][SprykConfig::NAME_ARGUMENT_KEY_DEFAULT] = $applicationLayer;
        } else {
            $arguments[SprykConfig::NAME_ARGUMENT_LAYER][SprykConfig::NAME_ARGUMENT_KEY_VALUE] = $applicationLayer;
        }

        $sprykConfig = $this->setArguments($arguments, $sprykConfig);

        return $sprykConfig;
    }

    /**
     * @param array $arguments
     *
     * @return string|null
     */
    protected function getApplicationLayer(array $arguments): ?string
    {
        if (!isset($arguments['targetPath'])) {
            return null;
        }

        $targetPath = $arguments['targetPath'][SprykConfig::NAME_ARGUMENT_KEY_DEFAULT] ?? $arguments['targetPath'][SprykConfig::NAME_ARGUMENT_KEY_VALUE];

        if (is_array($targetPath)) {
            $values = array_column($targetPath, SprykConfig::NAME_ARGUMENT_KEY_VALUE);
            $targetPath = array_shift($values);
        }

        if ((bool)strpos($targetPath, static::NAME_PLACEHOLDER_LAYER)) {
            return static::NAME_APPLICATION_LAYER_ZED;
        }

        $applicationLayer = strstr($targetPath, static::NAME_PLACEHOLDER_MODULE, true);

        if ($applicationLayer === false) {
            return static::NAME_APPLICATION_LAYER_ZED;
        }

        $applicationLayer = trim($applicationLayer, DIRECTORY_SEPARATOR);
        $applicationLayer = explode(DIRECTORY_SEPARATOR, $applicationLayer);

        return array_pop($applicationLayer);
    }

    /**
     * @param array $arguments
     *
     * @return bool
     */
    protected function isLayerPlaceholderExist(array $arguments): bool
    {
        if (!isset($arguments['targetPath'][SprykConfig::NAME_ARGUMENT_KEY_DEFAULT])) {
            return false;
        }

        $targetPath = $arguments['targetPath'][SprykConfig::NAME_ARGUMENT_KEY_DEFAULT];

        if (strpos($targetPath, static::NAME_PLACEHOLDER_LAYER) === false) {
            return false;
        }

        return true;
    }
}
