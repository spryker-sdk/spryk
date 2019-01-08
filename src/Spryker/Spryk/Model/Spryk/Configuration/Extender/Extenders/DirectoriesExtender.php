<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Configuration\Extender\Extenders;

use Spryker\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface;

class DirectoriesExtender extends AbstractExtender implements SprykConfigurationExtenderInterface
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

        return $this->buildProjectDirectories($sprykConfig);
    }

    /**
     * @param array $sprykConfig
     *
     * @return array
     */
    protected function buildProjectDirectories(array $sprykConfig): array
    {
        $arguments = $this->getArguments($sprykConfig);

        if ($arguments === []) {
            return $sprykConfig;
        }

        if (!isset($arguments['directories'])) {
            return $sprykConfig;
        }

        $arguments['directories']['value'] = [''];
        $sprykConfig = $this->setArguments($arguments, $sprykConfig);

        return $sprykConfig;
    }
}
