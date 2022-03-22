<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Structure;

use SprykerSdk\Spryk\Model\Spryk\Builder\AbstractBuilder;

class StructureSpryk extends AbstractBuilder
{
    /**
     * @var string
     */
    public const ARGUMENT_DIRECTORIES = 'directories';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'structure';
    }

    /**
     * @return bool
     */
    protected function shouldBuild(): bool
    {
        $shouldBuild = false;
        $directories = $this->getDirectoriesToCreate();

        foreach ($directories as $directory) {
//            $this->addDirectoryToAutoload($directory);
            if (!is_dir($directory)) {
                $shouldBuild = true;
            }
        }

        return $shouldBuild;
    }

    /**
     * @return void
     */
    protected function build(): void
    {
        $directories = $this->getDirectoriesToCreate();

        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
                $this->log(sprintf('Created <fg=green>%s</>', $directory));
            }
        }
    }

    /**
     * @return array<string>
     */
    protected function getDirectoriesToCreate(): array
    {
        $directories = $this->getArrayArgument(static::ARGUMENT_DIRECTORIES);

        $moduleDirectory = $this->getModuleDirectory();

        array_walk($directories, function (&$item) use ($moduleDirectory): void {
            $item = $moduleDirectory . $item;
        });

        return $directories;
    }

    /**
     * @return string
     */
    protected function getModuleDirectory(): string
    {
        return rtrim($this->getTargetPath(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    /**
     * Adds newly created modules to the autoloader to make reflection work.
     *
     * @param string $path
     *
     * @return void
     */
    protected function addDirectoryToAutoload(string $path): void
    {
        spl_autoload_register(function ($class) use ($path): void {
            if (!class_exists($class)) {
                $pathArray = explode('\\', rtrim($class, '\\'));
                unset($pathArray[0]);
                $file = $path . implode(DIRECTORY_SEPARATOR, $pathArray) . '.php';
                if (file_exists($file)) {
                    include $file;
                }
            }
        });
    }
}
