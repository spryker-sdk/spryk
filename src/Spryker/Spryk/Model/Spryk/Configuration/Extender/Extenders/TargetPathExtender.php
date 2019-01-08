<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Configuration\Extender\Extenders;

use Spryker\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface;

class TargetPathExtender extends AbstractExtender implements SprykConfigurationExtenderInterface
{
    /**
     * @param array $sprykConfig
     *
     * @return array
     */
    public function extend(array $sprykConfig): array
    {
        if ($this->isBoth($sprykConfig)) {
            return $sprykConfig;
        }

        if ($this->isCore($sprykConfig)) {
            return $sprykConfig;
        }

        return $this->buildProjectPath($sprykConfig);
    }

    /**
     * @param array $sprykConfig
     *
     * @return array
     */
    protected function buildProjectPath(array $sprykConfig): array
    {
        $arguments = $this->getArguments($sprykConfig);

        if ($arguments === []) {
            return $sprykConfig;
        }

        if (!isset($arguments['targetPath']['default'])) {
            return $sprykConfig;
        }

        $targetPath = $arguments['targetPath']['default'];

        $pathPattern = sprintf('/\%1$ssrc\%1$s.+/', DIRECTORY_SEPARATOR);

        preg_match($pathPattern, $targetPath, $result);

        if ($result !== []) {
            $targetPath = ltrim(array_shift($result), DIRECTORY_SEPARATOR);
        }

        $arguments['targetPath']['default'] = $targetPath;

        $sprykConfig = $this->setArguments($arguments, $sprykConfig);

        return $sprykConfig;
    }
}
