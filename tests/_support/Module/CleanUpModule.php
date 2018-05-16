<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Module;

use Codeception\Module;
use Codeception\TestInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class CleanUpModule extends Module
{
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
//            echo $fileInfo->getPathname() . PHP_EOL;
            $path = $fileInfo->getRealPath();
            $toDelete[] = $path;
//            chmod($path, 0777);
//
//            if (is_dir($path) || is_file($path) && is_readable($path)) {
//                $filesystem = new Filesystem();
//                $filesystem->remove($path);
//            }
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

        return $finder->getIterator();
    }

    /**
     * @return string
     */
    public function getRootDirectory(): string
    {
        if (strpos(APPLICATION_ROOT_DIR, '_data') === false) {
            return APPLICATION_ROOT_DIR . 'vendor/spryker/spryker/';
        }

        return APPLICATION_ROOT_DIR;
    }
}
