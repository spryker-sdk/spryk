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
        //todo: rewrite
        if (!$this->isProject($sprykConfig)) {
            return $sprykConfig;
        }

//        $developmentLayerName = $this->getDevelopmentLayer($sprykConfig);
//todo: check
        if (/*$developmentLayerName === null || */$this->isBoth($sprykConfig)) {
            return $sprykConfig;
        }

        $arguments = $this->getArguments($sprykConfig);

        if (!$arguments) {
            return $sprykConfig;
        }

        if (!isset($arguments['targetPath']['default'])) {
            return $sprykConfig;
        }

        $targetPath = $arguments['targetPath']['default'];

        preg_match('/\/src\/.+/', $targetPath, $result);

        if ($result !== []) {
            $targetPath = ltrim(array_shift($result), DIRECTORY_SEPARATOR);
        }

        $arguments['targetPath']['default'] = $targetPath;

        $sprykConfig = $this->setArguments($arguments, $sprykConfig);

        return $sprykConfig;
    }
}
