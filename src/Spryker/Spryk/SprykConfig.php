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
    public function getTemplateDirectories(): array
    {
        return [
            APPLICATION_ROOT_DIR . '/config/spryk/templates/',
        ];
    }
}
