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
        return $this->buildDirectoryList('spryks');
    }

    /**
     * @return string[]
     */
    public function getTemplateDirectories(): array
    {
        return $this->buildDirectoryList('templates');
    }

    /**
     * @param string $subDirectory
     *
     * @return string[]
     */
    protected function buildDirectoryList(string $subDirectory): array
    {
        return array_filter([
            sprintf('/%s/config/spryk/%s/', APPLICATION_ROOT_DIR, $subDirectory),
            realpath(sprintf('/%s/../../../config/%s/', __DIR__, $subDirectory)),
        ], 'is_dir');
    }
}
