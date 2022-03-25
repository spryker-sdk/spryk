<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk;

use Spryker\Shared\Config\Config;
use Spryker\Shared\Kernel\KernelConstants;

/**
 * @codeCoverageIgnore
 */
class SprykConfig
{
    /**
     * @var string
     */
    public const SPRYK_DEFINITION_KEY_LEVEL = 'level';

    /**
     * @var string
     */
    public const SPRYK_DEFINITION_KEY_ARGUMENTS = 'arguments';

    /**
     * @var string
     */
    public const NAME_DEVELOPMENT_LAYER_CORE = 'core';

    /**
     * @var string
     */
    public const NAME_DEVELOPMENT_LAYER_PROJECT = 'project';

    /**
     * @var string
     */
    public const NAME_DEVELOPMENT_LAYER_BOTH = 'both';

    /**
     * @var string
     */
    public const NAME_ARGUMENT_LAYER = 'layer';

    /**
     * @var string
     */
    public const NAME_ARGUMENT_MODE = 'mode';

    /**
     * @var string
     */
    public const NAME_ARGUMENT_ORGANIZATION = 'organization';

    /**
     * @var string
     */
    public const NAME_ARGUMENT_KEY_DEFAULT = 'default';

    /**
     * @var string
     */
    public const NAME_ARGUMENT_KEY_VALUE = 'value';

    /**
     * @var string
     */
    public const NAME_ARGUMENT_KEY_VALUES = 'values';

    /**
     * @var string
     */
    protected const NAME_DIRECTORY_GENERATED = 'generated';

    /**
     * @var string
     */
    protected const NAME_FILE_ARGUMENT_LIST = 'spryk_argument_list.yml';

    /**
     * @var string
     */
    protected const NAME_ORGANIZATION = 'spryker-sdk';

    /**
     * @var string
     */
    protected const NAME_PACKAGE = 'spryk';

    /**
     * @var int
     */
    protected const SPRYK_LEVEL_1 = 1;

    /**
     * @var int
     */
    protected const SPRYK_LEVEL_2 = 2;

    /**
     * @var int
     */
    protected const SPRYK_LEVEL_3 = 3;

    /**
     * @var int
     */
    public const SPRYK_DEFAULT_DUMP_LEVEL = self::SPRYK_LEVEL_1;

    /**
     * @return array<string>
     */
    public function getSprykDirectories(): array
    {
        return $this->buildDirectoryList('spryks');
    }

    /**
     * @return array<string>
     */
    public function getTemplateDirectories(): array
    {
        return $this->buildDirectoryList('templates');
    }

    /**
     * @param string|null $subDirectory
     *
     * @return array<string>
     */
    protected function buildDirectoryList(?string $subDirectory = null): array
    {
        $subDirectory = (is_string($subDirectory)) ? $subDirectory . DIRECTORY_SEPARATOR : DIRECTORY_SEPARATOR;

        $directories = [];
        $projectSprykDirectory = realpath($this->getRootDirectory() . 'config/spryk/' . $subDirectory);
        $sprykModuleDirectory = realpath($this->getSprykCorePath() . 'config/spryk/' . $subDirectory);

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
        return rtrim(APPLICATION_ROOT_DIR, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
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
     * @return array<int>
     */
    public function getAvailableLevels(): array
    {
        return [
            static::SPRYK_LEVEL_1,
            static::SPRYK_LEVEL_2,
            static::SPRYK_LEVEL_3,
        ];
    }

    /**
     * @return array
     */
    public function getCoreNamespaces(): array
    {
        $namespaces = [];
        /** @var string $namespacesFromEnv */
        $namespacesFromEnv = getenv('CORE_NAMESPACES');

        if ($namespacesFromEnv) {
            $namespaces = explode(',', $namespacesFromEnv);
        }

        return Config::get(
            KernelConstants::CORE_NAMESPACES,
            $namespaces,
        );
    }

    /**
     * @return string|null
     */
    public function getProjectNamespace(): ?string
    {
        return Config::get(KernelConstants::PROJECT_NAMESPACE, getenv('PROJECT_NAMESPACE') ?: '');
    }

    /**
     * @return array
     */
    public function getProjectNamespaces(): array
    {
        $namespaces = [];
        /** @var string $namespacesFromEnv */
        $namespacesFromEnv = getenv('PROJECT_NAMESPACES');

        if ($namespacesFromEnv) {
            $namespaces = explode(',', $namespacesFromEnv);
        }

        return Config::get(
            KernelConstants::PROJECT_NAMESPACES,
            $namespaces,
        );
    }

    /**
     * @return string
     */
    public function getArgumentListFilePath(): string
    {
        $generatedDirectory = $this->getSprykCorePath() . static::NAME_DIRECTORY_GENERATED;

        if (!file_exists($generatedDirectory)) {
            $generatedDirectory = $this->getRootDirectory() . static::NAME_DIRECTORY_GENERATED;
        }

        return realpath($generatedDirectory) . DIRECTORY_SEPARATOR . static::NAME_FILE_ARGUMENT_LIST;
    }

    /**
     * @return string
     */
    public function getDefaultDevelopmentMode(): string
    {
        return static::NAME_DEVELOPMENT_LAYER_PROJECT;
    }

    /**
     * @return int
     */
    public function getDefaultBuildLevel(): int
    {
        return static::SPRYK_LEVEL_3;
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

        return $this->getRootDirectory() . $sprykRelativePath . DIRECTORY_SEPARATOR;
    }

    /**
     * @return array<string, mixed>
     */
    public function getTwigConfiguration(): array
    {
        return [
            'debug' => false,
            'cache' => __DIR__ . '/../../var/cache/twig',
        ];
    }
}
