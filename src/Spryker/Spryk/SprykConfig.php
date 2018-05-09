<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk;

class SprykConfig
{
    /**
     * @return string[]
     */
    public function getSprykDirectories(): array
    {
        $sprykDirectories = [
            APPLICATION_ROOT_DIR . '/config/spryk/spryks/',
            realpath(__DIR__ . '/../../../config/spryks'),
        ];

        return array_filter($sprykDirectories, 'is_dir');
    }

    /**
     * @return string[]
     */
    public function getTemplateDirectories(): array
    {
        $templateDirectories = [
            APPLICATION_ROOT_DIR . '/config/spryk/templates/',
            realpath(__DIR__ . '/../../../config/templates'),
        ];

        return array_filter($templateDirectories, 'is_dir');
    }
}
