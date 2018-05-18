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
    public function getRootSprykDirectories(): array
    {
        return $this->buildDirectoryList();
    }

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
     * @param null|string $subDirectory
     *
     * @return string[]
     */
    protected function buildDirectoryList(?string $subDirectory = null): array
    {
        $subDirectory = ($subDirectory) ? $subDirectory . DIRECTORY_SEPARATOR : DIRECTORY_SEPARATOR;
        return array_filter([
            realpath($this->getRootDirectory() . '/config/spryk/' . $subDirectory),
            realpath(__DIR__ . '/../../../config/spryk/' . $subDirectory),
//            sprintf('/%s/config/spryk/%s/', $this->getRootDirectory(), $subDirectory),
//            realpath(sprintf('/%s/../../../config/%s/', __DIR__, $subDirectory)),
        ], 'is_dir');
    }

    /**
     * @return string
     */
    public function getRootDirectory(): string
    {
        return APPLICATION_ROOT_DIR;
    }
}
