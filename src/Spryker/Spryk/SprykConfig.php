<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk;

/**
 * @codeCoverageIgnore
 */
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

        $directories = [];
        $test = $this->getRootDirectory() . 'config/spryk/' . $subDirectory;
        $projectSprykDirectory = realpath($this->getRootDirectory() . 'config/spryk/' . $subDirectory);
        $sprykModuleDirectory = realpath($this->getRootDirectory() . 'vendor/spryker/spryk/config/' . $subDirectory);

        if ($projectSprykDirectory) {
            $directories[] = $projectSprykDirectory . DIRECTORY_SEPARATOR;
        }
        if ($sprykModuleDirectory) {
            $directories[] = $sprykModuleDirectory . DIRECTORY_SEPARATOR;
        }

        return $directories;
    }

    /**
     * @return string
     */
    public function getRootDirectory(): string
    {
        return APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR;
    }
}
