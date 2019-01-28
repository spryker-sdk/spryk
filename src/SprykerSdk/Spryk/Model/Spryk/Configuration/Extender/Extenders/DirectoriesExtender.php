<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders;

use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface;

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
