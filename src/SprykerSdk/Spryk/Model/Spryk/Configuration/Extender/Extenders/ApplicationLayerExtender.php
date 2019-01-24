<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders;

use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface;

class ApplicationLayerExtender extends AbstractExtender implements SprykConfigurationExtenderInterface
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

        if (isset($arguments['layer']['default'])) {
            return $sprykConfig;
        }

        $applicationLayer = $this->getApplicationLayer($arguments);

        if ($applicationLayer === null) {
            return $sprykConfig;
        }

        if ($this->isLayerPlaceholderExist($arguments)) {
            $arguments['layer']['default'] = $applicationLayer;
        } else {
            $arguments['layer']['value'] = $applicationLayer;
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
        //todo: refactoring
        if (!isset($arguments['targetPath'])) {
            return null;
        }

        $targetPath = $arguments['targetPath']['default'] ?? $arguments['targetPath']['value'];

//        if (!isset($arguments['targetPath']['default'])) {
//            return null;
//        }
//
//        $targetPath = $arguments['targetPath']['default'];

        if (is_array($targetPath)) { //todo: check
            $values = array_column($targetPath, 'value');
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
        if (!isset($arguments['targetPath']['default'])) {
            return false;
        }

        $targetPath = $arguments['targetPath']['default'];

        if (strpos($targetPath, static::NAME_PLACEHOLDER_LAYER) === false) {
            return false;
        }

        return true;
    }
}
