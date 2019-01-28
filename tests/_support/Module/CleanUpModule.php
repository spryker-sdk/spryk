<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdkTest\Module;

use Codeception\Module;
use Codeception\TestInterface;
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

        foreach ($toDelete as $item) {
            $filesystem = new Filesystem();
            $filesystem->remove($item);
        }
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
