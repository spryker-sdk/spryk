<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk;

use Spryker\Shared\Config\Config;
use Spryker\Shared\Kernel\KernelConstants;

/**
 * @codeCoverageIgnore
 */
class SprykConfig
{
    protected const NAME_DEVELOPMENT_LAYER_CORE = 'core';
    protected const NAME_DEVELOPMENT_LAYER_PROJECT = 'project';
    protected const NAME_DEVELOPMENT_LAYER_BOTH = 'both';

    protected const NAME_DIRECTORY_GENERATED = 'generated';
    protected const NAME_FILE_ARGUMENT_LIST = 'spryk_argument_list.yml';

    protected const NAME_ORGANIZATION = 'spryker-sdk';
    protected const NAME_PACKAGE = 'spryk';

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
     * @param string|null $subDirectory
     *
     * @return string[]
     */
    protected function buildDirectoryList(?string $subDirectory = null): array
    {
        $subDirectory = (is_string($subDirectory)) ? $subDirectory . DIRECTORY_SEPARATOR : DIRECTORY_SEPARATOR;

        $directories = [];
        $projectSprykDirectory = realpath($this->getRootDirectory() . 'config/spryk/' . $subDirectory);
        $sprykModuleDirectory = realpath(
            $this->getRootDirectory()
            . $this->getSprykCorePath()
            . $subDirectory
        );

        if ($projectSprykDirectory !== false) {
            $directories[] = $projectSprykDirectory . DIRECTORY_SEPARATOR;
        }
        if ($sprykModuleDirectory !== false) {
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

    /**
     * @return array
     */
    public function getAvailableDevelopmentLayers(): array
    {
        return [
            static::NAME_DEVELOPMENT_LAYER_CORE,
            static::NAME_DEVELOPMENT_LAYER_PROJECT,
            static::NAME_DEVELOPMENT_LAYER_BOTH,
        ];
    }

    /**
     * @return array
     */
    public function getCoreNamespaces(): array
    {
        return Config::get(KernelConstants::CORE_NAMESPACES, []);
    }

    /**
     * @return string|null
     */
    public function getProjectNamespace(): ?string
    {
        return Config::get(KernelConstants::PROJECT_NAMESPACE);
    }

    /**
     * @return array
     */
    public function getProjectNamespaces(): array
    {
        return Config::get(KernelConstants::PROJECT_NAMESPACES, []);
    }

    /**
     * @return string
     */
    public function getArgumentListFilePath(): string
    {
        $generatedDirectory = $this->getSprykCorePath() . DIRECTORY_SEPARATOR . static::NAME_DIRECTORY_GENERATED;

        if (!file_exists($generatedDirectory)) {
            $generatedDirectory = $this->getRootDirectory() . static::NAME_DIRECTORY_GENERATED;
        }

        return realpath($generatedDirectory) . DIRECTORY_SEPARATOR . static::NAME_FILE_ARGUMENT_LIST;
    }

    /**
     * @return string
     */
    protected function getSprykCorePath(): string
    {
        $sprykRelativePath = implode(DIRECTORY_SEPARATOR, [
            'vendor',
            static::NAME_ORGANIZATION,
            static::NAME_PACKAGE,
        ]);

        return $this->getRootDirectory()
            . DIRECTORY_SEPARATOR
            . $sprykRelativePath
            . DIRECTORY_SEPARATOR;
    }
}
