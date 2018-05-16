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
        $finder = $this->getFinder();

        if ($finder->valid()) {
            $filesystem = new Filesystem();
            $filesystem->remove($finder);
        }
    }

    /**
     * @return \Iterator|\Symfony\Component\Finder\SplFileInfo[]
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
