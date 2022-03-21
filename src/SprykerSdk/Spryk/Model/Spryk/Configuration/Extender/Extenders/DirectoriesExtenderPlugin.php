<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders;

use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderPluginInterface;

class DirectoriesExtenderPlugin extends AbstractExtender implements SprykConfigurationExtenderPluginInterface
{
    /**
     * @var string
     */
    protected const NAME_ARGUMENT_DIRECTORIES = 'directories';

    /**
     * @var string
     */
    protected const NAME_ARGUMENT_KEY_SKIP_ON_PROJECT_LEVEL = 'skipOnProjectLevel';

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

        if (!isset($arguments[static::NAME_ARGUMENT_DIRECTORIES])) {
            return $sprykConfig;
        }

//        $arguments[static::NAME_ARGUMENT_DIRECTORIES][SprykConfig::NAME_ARGUMENT_KEY_VALUE] = [''];
//        $sprykConfig = $this->setArguments($arguments, $sprykConfig);

        return $sprykConfig;
    }

    /**
     * @param array<mixed> $directoryArgumentDefinition
     *
     * @return bool
     */
    protected function isDirectoriesArgumentValidForProject(array $directoryArgumentDefinition): bool
    {
        if (
            isset($directoryArgumentDefinition[static::NAME_ARGUMENT_KEY_SKIP_ON_PROJECT_LEVEL])
            && $directoryArgumentDefinition[static::NAME_ARGUMENT_KEY_SKIP_ON_PROJECT_LEVEL] === 'true'
        ) {
            return false;
        }

        return true;
    }
}
