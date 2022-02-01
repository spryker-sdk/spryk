<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Module;

use Codeception\Module;
use Codeception\TestInterface;
use ReflectionClass;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolver;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class CleanUpModule extends Module
{
    /**
     * @var array
     */
    protected $config = ['rootDirectory' => ''];

    /**
     * @param \Codeception\TestInterface $test
     *
     * @return void
     */
    public function _before(TestInterface $test): void
    {
        if (!is_dir($this->getRootDirectory())) {
            return;
        }

        $finder = $this->getFinder();

        $toDelete = [];
        foreach ($finder as $fileInfo) {
            $path = $fileInfo->getRealPath();
            $toDelete[] = $path;
        }

        $filesystem = new Filesystem();
//        $filesystem->remove($this->getRootDirectory());
        $filesystem->remove(sprintf('%s/spryk', sys_get_temp_dir()));

        foreach ($toDelete as $item) {
            $filesystem->remove($item);
        }

        $fileResolverReflection = new ReflectionClass(FileResolver::class);
        $fileResolverReflection->setStaticPropertyValue('resolved', []);
    }

    /**
     * @return \Symfony\Component\Finder\SplFileInfo[]|\Symfony\Component\Finder\Finder
     */
    protected function getFinder()
    {
        $finder = new Finder();
        $finder->in($this->getRootDirectory())->notPath('config');

        return $finder;
    }

    /**
     * @return string
     */
    public function getRootDirectory(): string
    {
        $baseDir = realpath(__DIR__ . '/../../../');
        $rootDirectory = $baseDir . DIRECTORY_SEPARATOR . $this->config['rootDirectory'];

        return $rootDirectory;
    }
}
